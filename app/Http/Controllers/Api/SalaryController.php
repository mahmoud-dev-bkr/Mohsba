<?php

namespace App\Http\Controllers\Api;
use App\CompanySetting;
use App\Loan;
use App\Reposite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Employee;
use Carbon\Carbon;
use App\Salary;
use Exception;

class SalaryController extends Controller
{
    public function performSave(Request $request)
    {
            //find employee 
        $employee  =Employee::find($request->employee_id);
        $basic = $request->basic;
        $bones = $request->bonus;
        $financial_penalties = $request->financial_penalties;
        $insurance = $request->insurance;
        $loans = $request->loans;
        $madionia = $request->madionia;
        $transports = $request->transports;
        $date =$request->date;
        // overtime // 
        $overtime_price = $employee->overtime_price;
        $totalovertime = $employee->overTime($date);
        $totalaAmountOvertime =  $overtime_price*$totalovertime; 

        // late 
        $late = $employee->late($date);
        $hourDayPresentage = CompanySetting::first()->hourly_rate_per_day;
        $lateAmount = $late*$hourDayPresentage;
        // absence
        $absencePresentage = CompanySetting::first()->absence_percentage;
        $absenceAmount = $employee->absence($date) * $absencePresentage;

        // absence with permission 
        $absencewithpermsion_percentage = CompanySetting::first()->	absence_with_permission_precentage;
        $absencewithpermsion = $employee->abcenceWithPermission($date);
        $absencewithpermsionAmount = $absencewithpermsion_percentage*$absencewithpermsion;

        $decrement  = $madionia + $loans + $transports +  $financial_penalties + $insurance;
        $increment  = $bones + $totalaAmountOvertime ;
        
        
        $netSalary = $basic - $decrement;
        $netSalary =  $netSalary + $increment;

        //decrement absence ,absencewith permsission, late//
        $netSalary = ($netSalary)-($netSalary*$lateAmount/100);
      
        $netSalary = ($netSalary)-($netSalary*$absenceAmount/100);
        $netSalary = ($netSalary)-($netSalary*$absencewithpermsionAmount/100);
     
        //update salary to employee 
        $employee->update([
            'salary'=>$netSalary,
            'madionia_balance'=>$madionia,
            'solaf_balance'=>$loans
        ]);

        //add salary in history //
        Salary::create([
            'employee_id'=>$employee->id,
            'date'=>$date,
            'basic'=>$basic,
            'loans'=>$loans,
            'bonus'=>$bones,
            'insurance'=>$insurance,
            'financial_penalties'=>$financial_penalties,
            'net'=>$netSalary,
            'madionia'=>$madionia,
            'transports'=>$transports,
            'notes'=>$request->notes
        ]);
        // return $netSalary;

    
    }

    /**
     * save the bonus of employee 
     */
    public function saveBonus(Request $request)
    {
        try {
            if ($request->salary_id) {
                $salary = Salary::find($request->salary_id);
                $salary->update([
                    // 'salary' => $request->salary,
                    'insurance' => $request->insurance,
                    'bonus' => $request->bonus,
                    'financial_penalties' => $request->financial_penalties
                ]);
            } else {
                $salary = Salary::create([
                    'employee_id' => $request->employee_id,
                    'date' => $request->date,
                ]);
            }
        } catch (\Exception $e) {
        }
        return 1;
    }
}
