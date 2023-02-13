<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plans = DB::table('attendance_plan_details')->get();
        $ToDay =  date( "Y-m-d", strtotime(Carbon::now()));
        foreach ($plans as $plan) {
            $workAppointment = DB::table('work_appointments')->where('id', $plan->work_appointment_id)->first();
            $endDate = date( "Y-m-d", strtotime( "$plan->end_date" ) );
            if($endDate == $ToDay)
            {
                if($workAppointment->attendance_repeat == 1){
                    DB::table('attendance_plan_details')->insert([
                        'work_appointment_id'   => $plan->work_appointment_id,
                        'start_date'   => $plan->end_date,
                        'end_date'   => $endDate,
                    ]);

                    $DayWorkPlan = explode("," , $workAppointment->attendance_days);
                    $ToDay       = Carbon::now()->dayOfWeek + 2;
                    if(in_array($ToDay, $DayWorkPlan))
                    {
                        $EmpolyeesPlan = DB::table('assign_appointments')->where('work_appointment_id', $workAppointment->id)->pluck('employee_id')->toArray();

                        $employees                  =  DB::table('employees')->select('employees.id as employee_id'  , 'employees.branch_id','work_appointment_id as appointment_id')
                        ->leftJoin('assign_appointments',  'assign_appointments.employee_id', '=', 'employees.id')
                        ->whereIn('employees.id', $EmpolyeesPlan)->get()->toArray();
                        foreach ($employees as $key ) {
                            $key->date = date( "Y-m-d", strtotime(Carbon::now()));
                            $attendance_and_departure   = AttendanceAndDeparture::insert((array)$key);
                        }

                    }
                }
            }
        }
        return 1;
    }
}
