<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Branch;
use App\Job;
use App\Attendancemethod;
use App\AttendancePlanDetail;
use App\Utils\Util;
use Carbon\Carbon;
use Exception;

class Employee extends Model
{

    protected $fillable = [
        'name', 'username','firebase_token', 'email', 'address', 'phone', 'password', 'age', 'branch_id', 'gender', 'job_id', 'job_number', 'otp', 'created_at', 'updated_at', 'solaf_balance', 'salary', 'madionia_balance',
        'has_image', 'has_voice', 'has_finger', 'counter_reg','overtime_price','business_id', 'job_category_id'
    ];

    public static function notify($title_ar,$title_en,$message_ar, $message_en, $icon, $userId) {
        try{
           // DB::statement("delete from notifications where user_type='PATIENT' and user_id=$userId ");
            $notification = Notification::create([
                "title_en" => $title_en,
                "title_ar" => $title_ar,
                "message_en" =>$message_en,
                "message_ar"=>$message_ar,
                "icon"=>$icon? $icon : 'icon',
                "user_id"=>$userId,
                ]);



            $data = [
                "title_ar" => $title_ar,
                "title_en" => $title_en,
                "body_ar" => $message_ar,
                "body_en" => $message_en,
            ];

            $token = [
                // 'fad9AzthR_-DWNaBI_SPI7:APA91bHsbC8_VtbnS-SK4-4NiLHUIYl9pJifVlZAOzAt-r030ILVIhZUzPJHhIK4KXouNwP3W79F3m-4caVvIzcPcNlFxrztFXd9qZkr7CUZCZbbiuXYPmcGT5zPPF1E3rOZHT0qWdkK'
                Employee::find($userId)->firebase_token
            ];

            return Util::firebaseNotification($token, $data);
        }catch(Exception $e){
            return $e;
        }
    }
    //
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function attend_methods()
    {
        return $this->belongsToMany(Attendancemethod::class, 'employee_attend_methods', 'employee_id', 'attend_method_id')->withPivot('optional');
    }
    public function extra_time()
    {
        return $this->hasMany(ExtraTime::class, 'employee_id');
    }

    public function assign_appointments()
    {
        return $this->hasMany(AssignAppointment::class);
    }
    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'assign_appointments', 'employee_id', 'work_appointment_id');
    }
    public function appointmentsIds()
    {
        return $this->assign_appointments()->pluck('work_appointment_id')->toArray();
    }

    public function requests()
    {
        return $this->hasMany(EmployeeRequest::class);
    }

    public function attendeces()
    {
        return Transport::where("employee_id", $this->id)->sum("rate");
    }

    public function salaries()
    {
        return $this->hasMany('App\Salary');
    }

    public function attendanceanddeparture()
    {
        return $this->hasMany(AttendanceAndDeparture::class);
    }

    //business //
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
    ///

    //job category //
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function absence($date)
    {
        //get start of month from date //
        $selected_date = Carbon::parse($date);
        $startofMonth = Carbon::parse($date)->startOfMonth();
        //get abcence employee count //
        $absenceCount = $this->attendanceanddeparture()
        ->where('date','>=',$startofMonth)->where('date','<=',$selected_date)
        ->where('absence','=',1)->count();
        return $absenceCount;

    }//EndMethod

    public function abcenceWithPermission($date)
    {
        //get start of month from date //
        $selected_date = Carbon::parse($date);
        $startofMonth = Carbon::parse($date)->startOfMonth();
        //get abcence employee count //
        $absenceWithPermissionCount = $this->attendanceanddeparture()
        ->where('date','>=',$startofMonth)->where('date','<=',$selected_date)
        ->where('absence_with_permission','=',1)->count();
        //return count //
        return $absenceWithPermissionCount;

    }//EndMethod
    public function abcenceWithVacation($date)
    {
        //get start of month from date //
        $selected_date = Carbon::parse($date);
        $startofMonth = Carbon::parse($date)->startOfMonth();
        //get abcence employee count //
        $abcenceWithVacation = $this->attendanceanddeparture()
        ->where('date','>=',$startofMonth)->where('date','<=',$selected_date)
        ->where('absence_with_vacation','=',1)->count();
        //return count //
        return $abcenceWithVacation;
    }//EndMethod
    public function getAttendanceEmployee($date)
    {
        $selected_date = Carbon::parse($date);
        $startofMonth = Carbon::parse($date)->startOfMonth();
        $attendances = AttendanceAndDeparture::where('employee_id',$this->id)
        ->where('date','>=',$startofMonth)->where('date','<=',$selected_date)
        ->where('absence','0')->where('absence_with_permission','0')->where('absence_with_vacation','0')->get();
        return $attendances;
    }//EndMethod
    public function workHours($date)
    {
        $totalhours = 0;
        $attendances = $this->getAttendanceEmployee(Carbon::parse($date));
        foreach($attendances as $attendance)
        {
            $start_p1 = Carbon::parse($attendance->attend_time_p1);
            $end_p1 = Carbon::parse($attendance->depart_time_p1);
            $totalhours += $end_p1->diffInHours($start_p1);
            if($attendance->attend_time_p2 != null && $attendance->depart_time_p2 != null)
            {
                $start_p2 = Carbon::parse($attendance->attend_time_p2);
                $end_p2 = Carbon::parse($attendance->depart_time_p2);
                $totalhours += $end_p2->diffInHours($start_p2);
            }
            //decrement overTime //
            if($attendance->overtime_minutes != null )
            {
                $totalhours -= $attendance->overtime_minutes;
            }
        }
        return $totalhours;
    }//EndMethod

    // public function absenceWithVacations($date)
    // {
    //     $totalAbsenceWithPermission = 0;
    //     $date = Carbon::parse($date);
    //     $absenceWithPermission = $this->attendanceanddeparture()
    //         ->whereMonth('date', $date->month)
    //         ->whereYear('date', $date->year)
    //         ->where('absence_with_permission', true)->count();
    //         $attendancePlanDetails = AttendancePlanDetail::whereMonth('start_date', $date->month)
    //         ->whereYear('start_date', $date->year)->pluck('work_appointment_id');
    //         foreach($attendancePlanDetails as $key=>$index){
    //             $appointment = Appointment::find($index);
    //             $i[] = explode(',', $appointment->attendance_days); // 1,2,3,4,5
    //             // dd($i);
    //             // check if today is a workday
    //             $today = Carbon::today()->dayOfWeek + 2;

    //             if ($today > 7) $today = 1;

    //             if (!in_array((string)$today, explode(',', $appointment->attendance_days))) {
    //                 // today is not a work day
    //                 return response()->json(['status' => 0, 'message' => "today is not a work day"], 403);
    //             }

    //             // dd($appointment);
    //         }

    //     // dd($this->appointmentsIds());
    //     if ($absenceWithPermission > 0) {
    //         for ($i = 1; $i <= $absenceWithPermission; $i++) {
    //             $totalAbsenceWithPermission = $totalAbsenceWithPermission + $i;
    //         }
    //         // $totalAbsenceWithPermission = $totalAbsenceWithPermission - 1;
    //     }
    //     return $totalAbsenceWithPermission;

    // }

    // public function absence($date)
    // {
    //     $totalAbsence = 0;
    //     $date = Carbon::parse($date);
    //     $absenceWithPermission = $this->attendanceanddeparture()
    //         ->whereMonth('date', $date->month)
    //         ->whereYear('date', $date->year)
    //         ->where('absence_with_permission', true)->count();

    //     $attendDays = $this->attendanceanddeparture()
    //         ->whereMonth('date', $date->month)
    //         ->whereYear('date', $date->year)
    //         ->get();
    //     $attendancePlanDetails = AttendancePlanDetail::whereMonth('start_date', $date->month)
    //         ->whereYear('start_date', $date->year)->pluck('work_appointment_id');
    //     foreach ($attendancePlanDetails as $key => $index) {
    //         $appointment = Appointment::find($index);
    //         $i[] = explode(',', $appointment->attendance_days); // 1,2,3,4,5
    //         dd($i);
    //         // check if today is a workday
    //         $today = Carbon::today()->dayOfWeek + 2;

    //         if ($today > 7) $today = 1;

    //         if (!in_array((string)$today, explode(',', $appointment->attendance_days))) {
    //             // today is not a work day
    //             return response()->json(['status' => 0, 'message' => "today is not a work day"], 403);
    //         }

    //         dd($appointment);
    //     }

    //     // dd($this->appointmentsIds());
    //     if ($absence > 0) {
    //         for ($i = 1; $i <= $absence + 1; $i++) {
    //             $totalAbsence = $totalAbsence + $i;
    //         }
    //         $totalAbsence = $totalAbsence - 1;
    //     }
    //     $totalAbsence = $totalAbsence + $absenceWithPermission;
    //     return $totalAbsence;
    // }

    public function late($date)
    {
        $totalLate = 0;
        $attendances =  $this->getAttendanceEmployee(Carbon::parse($date));
        foreach($attendances as $attendance)
        {
            $totalLate+= $attendance->late;
        }
        return $totalLate;
    }

    public function overTime($date)
    {
        $totalovertimehours = 0;
        $attendances =  $this->getAttendanceEmployee(Carbon::parse($date));
        foreach($attendances as $attendance)
        {
            $totalovertimehours += $attendance->overtime_minutes;
        }
        return $totalovertimehours;
    }//EndMethod

    public function calcSalary($date,$basic)
    {
        $company = CompanySetting::first();
        $selected_date =  Carbon::parse($date);
        // $attendanceHour = $this->workHours($selected_date);
        $overTime = $this->overTime($selected_date);
        // $price_per_hour = $company->hourly_rate_per_day;
        $overtime_price = $this->overtime_price;

        $salary =  ($basic) + ($overTime * $overtime_price);
        return $salary;
    }

    public function getEmployeeTodayAppointments()
    {
        $employee = $this;

        $today = Carbon::today()->dayOfWeek + 2;
        if ($today > 7) $today = 1;
        // saturday -> 1
        // sunday -> 2
        // ---
        // friday -> 7
        $appointments = $this->appointments()->with(['branch:latitude,longituide,id,name', 'branch.wifi:id,branch_id,ssid,bssid', 'branch.becon:id,branch_id,code', 'locations'])->whereRaw("find_in_set('" . $today . "',attendance_days)")->get();

        foreach ($appointments as $appointment) {
            $this->appointmentCheck('1', $appointment, $employee->id);
            if ($appointment->start_from_period_2) {
                $this->appointmentCheck('2', $appointment, $employee->id);
            }
        }

        return $appointments;
    }

    public function appointmentCheck($period, $appointment, $emp_id)
    {
        $attendance = AttendanceAndDeparture::where(
            [
                ['employee_id', $emp_id],
                ['date', Carbon::today()],
                ['appointment_id', $appointment->id],
            ]
        )->first();

        if ($attendance) {
            if (($attendance->attend_time_p1 && $period == 1) || ($attendance->attend_time_p2 && $period == 2)) {
                $appointment['attended_period_' . $period] = true;
            } else {
                $appointment['attended_period_' . $period] = false;
            }
        } else {
            $appointment['attended_period_' . $period] = false;
        }

        //////////////////////////////////////////////////////////
        $departure = AttendanceAndDeparture::where(
            [
                ['employee_id', $emp_id],
                ['date', Carbon::today()],
                ['appointment_id', $appointment->id],
            ]
        )->first();


        if ($departure) {
            if (($departure->depart_time_p1 && $period == 1) || ($departure->depart_time_p2 && $period == 2)) {
                $appointment['departure_period_' . $period] = true;
            } else {
                $appointment['departure_period_' . $period] = false;
            }
        } else {
            $appointment['departure_period_' . $period] = false;
        }
        return $appointment;
    }

    public function loans()
    {
        return $this->hasMany('App\Loan');
    }


    public function transports()
    {
        return $this->hasMany('App\Transport');
    }

    public function getTransports()
    {
        return Transport::where("employee_id", $this->id)->sum("rate");
    }


    //get absense employees //

    function absenceEmployeeDaily($date)
    {
        $date = Carbon::parse($date);
        $attendance = $this->attendanceanddeparture()->where('date',$date);
        if(!$attendance)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function absenceEmployeeCount($from,$to)
    {

        $from =date( "Y-m-d", strtotime($from));
        $to =date( "Y-m-d", strtotime($to));
        $attendance = $this->attendanceanddeparture()->whereBetween('date',[$from,$to])->get();
        // return $attendance;
        if(!$attendance)
        {
            $absenceCount = $attendance->count();
            return $absenceCount;
        }
    }



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($employee) {
            $relationMethods = ['assign_appointments', 'attend_methods'];
            foreach ($relationMethods as $relationMethod) {
                if ($employee->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
