<?php

namespace App\Http\Controllers\api;

use App\Appointment;
use App\AssignAppointment;
use App\Employee;
use App\EmployeeDeparture;
use App\Http\Controllers\Controller;
use App\RegisteredDepartureMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartureController extends Controller
{
    //
    public function set_employee_departure(Request $request)
    {
        $rules = array(
            'emp_id' => 'required',
            'appointment_id' => 'required',
            'period' => 'required|in:1,2',
            'departure_methods' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $emp = Employee::find($request->emp_id);
        if (!$emp) {
            return response()->json(['status' => 0, 'message' => 'errors', 'errors' => [
                'employee' => 'the employee is not found'
            ]], 404);
        }

        // if employees make attendance today before //
        // return Carbon::today();
        $check = EmployeeDeparture::where([
            ['date', Carbon::today()->format('Y-m-d')],
            ['appointment_id', $request->appointment_id],
            ['period', $request->period],
            ['employee_id', $request->emp_id],
        ])->first();

        if ($check != null) {
            //emp make attendance before
            return response()->json([
                'status' => 0, 'message' => 'You Have Made an Departure before'
            ], 400);
        }

        // employees is found
        // check if employee on this plan or not
        $emp_appointments_ids = $emp->appointmentsIds();
        if (!in_array($request->appointment_id, $emp_appointments_ids)) {
            return response()->json(['status' => 0, 'message' => 'errors', 'errors' => [
                'employee' => 'the employee is not associated in this appointment'
            ]], 404);
        }


        // the employee is on this plan
        $is_valid_attend_methods = true;
        foreach ($request->departure_methods as $method) {
            if (!$method['state']) {
                $is_valid_attend_methods = false;
                return;
            }
        }

        $emp_departure = new EmployeeDeparture();

        $appointment = Appointment::find($request->appointment_id);
        $emp_departure->employee_id = $request->emp_id;
        $emp_departure->branch_id = $appointment->branch_id;
        $emp_departure->appointment_id = $request->appointment_id;

        if (!$is_valid_attend_methods) {
            $emp_departure->state = false;
        } else {
            // every attend methods is valid
            // check the time
            //get overtime to the employee //
            $assign_appointment  = AssignAppointment::where('work_appointment_id', $request->appointment_id)->where('employee_id', $request->emp_id)->first();
            $overtime_minutes = Carbon::parse($assign_appointment->over_time)->secondsSinceMidnight() / 60;
            $now = Carbon::now();


            $period = $request->period;
            $end = Carbon::parse($appointment['end_to_period_' . $period]);
            $end_with_overtime = $end->copy()->addMinutes($overtime_minutes);

            if ($now->gte($end)) {
                // he can leave
                $emp_departure->state = true;

                // check if the employee didn't complete his/her overtime
                if ($now->lt($end_with_overtime)) {
                    // get different overtime
                    $overtime_minutes_diff = $now->diffInMinutes($end);
                    $emp_departure->overtime_minutes_diff = $overtime_minutes_diff;
                }
            } else {
                // he can't leave
                // $plan_id = Setting::find(1)->value;
                return response()->json(['status' => 0, 'msg' => 'you still have ' . $end->copy()->diffInMinutes($now) . ' minutes to go'], 401);
            }
        }

        $emp_departure->date = date('Y-m-d');
        $emp_departure->period = $request->period;
        $emp_departure->save();
        // store the attend methods ids with status
        $registered_departure_methods = [];
        // save attendence methods status
        foreach ($request->departure_methods as $method) {

            array_push($registered_departure_methods, [
                'employee_id' => $request->emp_id,
                'attend_mthod_id' => (int) $method['method_id'],
                'plan_id' => $request->appointment_id,
                'location_id' => $appointment->location_id,
                'state' => $method['state'],
                'departure_id' => $emp_departure->id
            ]);
        }
        RegisteredDepartureMethod::insert($registered_departure_methods);

        return response()->json(['status' => 1, 'msg' => 'successful departure']);
    }
}
