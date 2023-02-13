<?php

namespace App\Http\Controllers\api;

use App\Appointment;
use App\AssignAppointment;
use App\AttendanceAndDeparture;
use App\Device;
use App\Employee;
use App\Http\Controllers\Controller;
use App\RegisteredAttendanceMethod;
use App\RegisteredEmployeeAttendandanceDepartureMethod;
use App\Vacation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Utils\Util;

class AttendanceAndDepartureController extends Controller
{

    public function isVacationDay($date)
    {
        //check if today is in vacation //
        $is_vacation = Vacation::where('date', $date)->first();
        if ($is_vacation) {
            return true;
        }
    }//end method

    //check if employee is student or constructor
    public function checkIfInstructor($employee_id)
    {
        //find employees //
        $employee = Employee::find($employee_id);
        if($employee->job->type == 'instructor')
        {
            return true;
        }else{
            return false;
        }
    }
    /////////////////////////////////////////////

    public function genreateOtp($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        if($appointment)
        {
            $appointment->update([
                'otp' => rand(11111, 99999)
            ]);
            $otp = $appointment->otp;
            return $otp;
        }
        else{
            return response(['status' => '0', 'message' => 'error', 'error' => [
                'employee' => 'the Appointment is not found'
            ]], 404);
        }
    }


    /**
     * generate sms id to send in request of sms
     * @return SMSID '52d2d256302d2d'
     */
    public function generateSMSID(){
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $SMSID = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return $SMSID;
    }


    /**
     * send sms of otp
     * @param $phone text
     * @param $type enum 'appointment', 'employee'
     * @return $appointment Appointment
     */
    public function sendSMS($phone , $type, $planID=null){
        $SMSID = $this->generateSMSID();

        if($type == 'appointment'){
            $otp = $this->genreateOtp($planID);
            $receivePhone = $phone;

        }else if($type == 'employee'){
            $employee = Employee::where('phone', $phone)->first();
            if(!$employee){
                return false;
            }else{
                $receivePhone = $employee->phone;
                $otp = rand(11111, 99999);
                $employee->update([
                    'otp' =>$otp
                ]);
            }

        }else{
            return response()->json(
                [
                    'status' => 0,
                    'msg' => 'you should entery the type',
                ]);
        }
        // API URL
        $url = 'https://smsvas.vlserv.com/VLSMSPlatformResellerAPI/NewSendingAPI/api/SMSSender/SendSMS';

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $data = array(
            'UserName'      => 'SphinxatAPI',
            'Password'      => 'w>|*WVHq%3',
            'SMSText'       => 'your code is '. $otp,
            'SMSLang'       => 'E',
            'SMSSender'     => 'Ai attend',
            'SMSReceiver'   => $receivePhone,
            'SMSID'         => $SMSID,
        );
        $payload = json_encode($data);
        // $payloadObj = (object) $payload;

        // return $payload;

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);

        return $result;
    }


    public function set_employee_attendance(Request $request)
    {
        // vaidation //
        $rules = array(
            'emp_id' => 'required',
            'appointment_id' => 'required',
            'period' => 'required|in:1,2',
            'attendance_methods' => 'required',
            'localization_methods' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        //find employee //
        $employee = Employee::find($request->emp_id);

        if (!$employee) {
            return response(['status' => '0', 'message' => 'error', 'error' => [
                'employee' => 'the employee is not found'
            ]], 404);
        }

        //check if employee is in plan //
        $emp_appointments_ids = $employee->appointmentsIds();
        if (!in_array($request->appointment_id, $emp_appointments_ids)) {
            return response()->json([
                'status' => 0, 'message' => 'the employee is not associated in this appointment'
            ], 401);
        }

        $appointment = Appointment::find($request->appointment_id);

        if (!$appointment['start_from_period_2'] && $request->period == 2) {
            return "appointment doesn't have period 2";
        }

        if (!$appointment->isTodayWorkDay()) {
            // today is not a work day
            return response()->json(['status' => 0, 'message' => "today is not a work day"], 403);
        }

        //check if day is Vacation //
        if ($this->isVacationDay(Carbon::today()) == true) {
            return response()->json([
                'status' => 0, 'message' => 'Today is Vacation day'
            ], 403);
        }


        // check if employee is make attendance before //
        $attendance = AttendanceAndDeparture::where(
            [
                ['employee_id', $request->emp_id],
                ['date', Carbon::today()],
                ['appointment_id', $request->appointment_id],
            ]
        )->first();

        if ($attendance) {
            if ($attendance['attend_time_p' . $request->period]) {
                return response()->json([
                    'status' => 0, 'message' => 'You Have Made an Attendance before'
                ], 400);
            }
        }
        //check if period is 1 or 2 //
        return $this->handlePeriodCheckforattend($request, $appointment, $attendance, $employee);
    }//end method




    private function handlePeriodCheckforattend($request, $appointment, $employee_attedance, $employee)
    {
        $period = $request->period;

        if (!$employee_attedance) {
            $employee_attedance = new AttendanceAndDeparture();
            $employee_attedance->employee_id = $request->emp_id;
            $employee_attedance->branch_id = $appointment->branch_id;
            $employee_attedance->appointment_id = $request->appointment_id;
            $employee_attedance->date = Carbon::today();
        }

        $employee_attedance['attend_time_p' . $period] = Carbon::now()->format('H:i:s');

        $pass_localization_methods = true;
        $msg_reason = '';
        foreach ($request->localization_methods as $method) {
            //  method => {type : 'gps' , value : 35.45648,87,54879 ,state : 0]
            //  method => {type : 'becon' , value : {id} ,state : 1}   {id} is the id of the becon device
            //  method => {type : 'wifi' , value : {id} ,state : 1}   {id} is the id of the wifi device
            if (!$method['state']) {
                $type = $method['type'];
                $pass_localization_methods = false;
                $details = '';
                if ($type == 'gps') {
                    $details .= ' the employee tried to register an attendance with the coordinates : ' . $method['value'];
                } else {
                    $device = Device::find($method['value']);
                    $details .= ' the employee tried to register an attendance with the device ' . $device->device_name();
                }
                $msg_reason .= ' the localization method ' . $type . ' failed ' . $details . ' .';
            }
        }

        if (!$pass_localization_methods) {
            $employee_attedance['attend_state_p' . $period] = false;
            $employee_attedance['attend_reason_p' . $period] = $msg_reason;
        } else {
            // the employee passed the verification and localization methods
            // checking the time
            $now = Carbon::now();

            // add the delay time to the start time
            $start = Carbon::parse($appointment['start_from_period_' . $period]);
            // $end = Carbon::parse($appointment['end_to_period_' . $period]);
            $allow_delay_minutes =  Carbon::parse($appointment['delay_period_' . $period])->secondsSinceMidnight() / 60;

            // check if the now between the start and end
            if ($now->gte($start->copy()->subMinutes(15)) && $now->lte($start->copy()->addMinutes($allow_delay_minutes))) {
                $employee_attedance['attend_state_p' . $period] = true;
            } else {
                // get the different in minutes
                // to know how many minutes the employee is late
                $diff = $now->copy()->diffInMinutes($start);
                $diff_identifier = 'minutes';
                if ($diff > 60) {
                    $diff = floor($diff / 60);
                    $diff_identifier = 'hours';
                }
                $employee_attedance['attend_state_p' . $period] = false;
                $employee_attedance['attend_reason_p' . $period] = "the employee is late " . $diff . ' ' . $diff_identifier;
                $employee_attedance['late'] = $diff;
                if ($now->lt($start)) {
                    // employee is early
                    $msg = "the employee is early " . $diff . ' ' . $diff_identifier;
                    return response()->json(['status' => 0, 'message' => $msg], 200);
                }
            }
        }


        // return $employee_attedance;
        $registered_attend_depart_methods = [];
        // save attendence methods status
        

        //otp //
        if($this->checkIfInstructor($employee_attedance->employee_id) == true)
        {
           //instructor //
           $employee_attedance->save();

           if ($request->attendance_methods) {
                foreach ($request->attendance_methods as $method) {

                    array_push($registered_attend_depart_methods, [
                        'employee_id' => $request->emp_id,
                        'period' => $request->period,
                        'attend_method_id' => (int) $method['method_id'],
                        'plan_id' => $request->appointment_id,
                        'location_id' => $appointment->location_id,
                        'state' => $method['state'],
                        'attendance_id' => $employee_attedance['id']
                    ]);
                }
            }
            RegisteredEmployeeAttendandanceDepartureMethod::insert($registered_attend_depart_methods);

          
            $employeeInstructor = Employee::find($employee_attedance->employee_id);

            // $result = $this->sendSMS($employeeInstructor->phone, 'appointment',$employee_attedance->appointment_id);
            $util = new Util();
            $otp = $util->sendSMS($employeeInstructor->phone, 'appointment', $employee_attedance->appointment_id);
        //    $otp =  $this->genreateOtp($employee_attedance->appointment_id);

           return response()->json(
               [
                   'status' => 1,
                   'msg' => 'Success',
                   'otp' => $otp
               ]
           );
       }
       else{
           //check if student or adminstrative //
           if($employee->job->type == 'student')
           {
               //check if otp is same in plan
               if($request->otp != $appointment->otp)
               {
                   return response(['status' => 0, 'msg' => 'Invail OTP'], 401);
               }
           }
        //    RegisteredEmployeeAttendandanceDepartureMethod::insert($registered_attend_depart_methods);
           $employee_attedance->save();
           if ($request->attendance_methods) {
                foreach ($request->attendance_methods as $method) {
                
                    array_push($registered_attend_depart_methods, [
                        'employee_id' => $request->emp_id,
                        'period' => $request->period,
                        'attend_method_id' => (int) $method['method_id'],
                        'plan_id' => $request->appointment_id,
                        'location_id' => $appointment->location_id,
                        'state' => $method['state'],
                        'attendance_id' => $employee_attedance['id']
                    ]);
                }
            }
            RegisteredEmployeeAttendandanceDepartureMethod::insert($registered_attend_depart_methods);

           return response()->json(
            [
                'status' => 1,
                'msg' => 'Success',
            ]
        );
        }
    }//end method

    public function set_employee_departure(Request $request)
    {
        //validation//
        $rules = array(
            'emp_id' => 'required',
            'appointment_id' => 'required',
            'period' => 'required|in:1,2',
            'departure_methods' => 'required',
            'localization_methods' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()], 422);
        }

        //check if employee is exist //
        $emp = Employee::find($request->emp_id);
        if (!$emp) {
            return response()->json(['status' => 0, 'message' => 'errors', 'errors' => [
                'employee' => 'the employee is not found'
            ]], 404);
        }


        $appointment = Appointment::find($request->appointment_id);

        if (!$appointment->isTodayWorkDay()) {
            // today is not a work day
            return response()->json(['status' => 0, 'message' => "today is not a work day"], 403);
        }

        //check if day is Vacation //
        if ($this->isVacationDay(Carbon::today()) == true) {
            return response()->json([
                'status' => 0, 'message' => 'Today is Vacation day'
            ], 403);
        }

        if (!$appointment['start_from_period_2'] && $request->period == 2) {
            return "appointment doesn't have period 2";
        }

        //check is employee have made attendance before //
        $departure = AttendanceAndDeparture::where(
            [
                ['employee_id', $request->emp_id],
                ['date', Carbon::today()],
                ['appointment_id', $request->appointment_id],
            ]
        )->first();


        if ($departure) {
            if ($departure['depart_time_p' . $request->period]) {
                return response()->json([
                    'status' => 0, 'message' => 'You Have Made an Departure before'
                ], 400);
            }
        } else {
            return "no attendance yet";
        }

        //check if 1 or 2 //
        return $this->handlePeriodCheckforDeparture($request, $appointment, $departure, $emp);
        // return $employee_departure;
    }//end method


    private function handlePeriodCheckforDeparture($request, $appointment, $employee_departure, $employee)
    {
        $period = $request->period;

        $employee_departure['depart_time_p' . $period] = Carbon::now()->format('H:i:s');


        $pass_localization_methods = true;
        $msg_reason = '';
        foreach ($request->localization_methods as $method) {
            //  method => {type : 'gps' , value : 35.45648,87,54879 ,state : 0]
            //  method => {type : 'becon' , value : {id} ,state : 1}   {id} is the id of the becon device
            //  method => {type : 'wifi' , value : {id} ,state : 1}   {id} is the id of the wifi device
            if (!$method['state']) {
                $pass_localization_methods = false;

                $type = $method['type'];
                $details = '';
                if ($type == 'gps') {
                    $details .= ' the employee tried to register an attendance with the coordinates : ' . $method['value'];
                } else {
                    $device = Device::find($method['value']);
                    $details .= ' the employee tried to register an attendance with the device ' . $device->device_name();
                }
                $msg_reason .= ' the localization method ' . $type . ' failed ' . $details . ' .';
            }
        }

        if (!$pass_localization_methods) {
            $employee_departure['depart_state_p' . $period] = false;
            $employee_departure['depart_reason_p' . $period] = $msg_reason;
        } else {
            $assign_appointment  = AssignAppointment::where('work_appointment_id', $request->appointment_id)->where('employee_id', $request->emp_id)->first();

            $overtime_minutes = Carbon::parse($assign_appointment->over_time)->secondsSinceMidnight() / 60;
            $now = Carbon::now();
            $end = Carbon::parse($appointment['end_to_period_' . $period]);


            $end_with_overtime = $end->copy()->addMinutes($overtime_minutes);

            if ($now->gte($end)) {
                // he can leave
                $employee_departure['depart_state_p' . $period] = true;

                // check if the employee didn't complete his/her overtime
                if ($now->lt($end_with_overtime)) {
                    // get different overtime
                    $overtime_minutes_counted = $now->diffInMinutes($end);
                    if ($period == 2 || ($period == 1 && !$appointment['start_from_period_2'])) {
                        $employee_departure->overtime_minutes = $overtime_minutes_counted;
                    }
                }
            } else {
                // he can't leave
                // $plan_id = Setting::find(1)->value;
                return response()->json(['status' => 0, 'msg' => 'you still have ' . $end->copy()->diffInMinutes($now) . ' minutes to go'], 401);
            }
        }
        $employee_departure->save();

        //add in history //
        $histroy = [
            'employee_id' => $employee_departure->employee_id,
            'plan_id' => $employee_departure->appointment_id,
            'branch_id' => $employee_departure->branch_id,
            'location_id' => $employee_departure->appointment->location_id,
            'overtime' => $employee_departure->overtime_minutes,

        ];



        $registered_attend_depart_methods = [];
        // save attendence methods status
        if ($request->departure_methods) {
            foreach ($request->departure_methods as $method) {

                array_push($registered_attend_depart_methods, [
                    'employee_id' => $request->emp_id,
                    'period' => $request->period,
                    'attend_method_id' => (int) $method['method_id'],
                    'plan_id' => $request->appointment_id,
                    'location_id' => $appointment->location_id,
                    'state' => $method['state'],
                    'departure_id' => $employee_departure->id
                ]);
            }
        }

        if($this->checkIfInstructor($employee_departure->employee_id) == true)
        {
           //instructor //
           RegisteredEmployeeAttendandanceDepartureMethod::insert($registered_attend_depart_methods);
           $employee_departure->save();
           DB::table('employee_plan_history')->insert($histroy);

           $otp =  $this->genreateOtp($employee_departure->appointment_id);
           return response()->json(
               [
                   'status' => 1,
                   'msg' => 'Success',
                   'otp' => $otp
               ]
           );
       }
       else{
        //check if student or adminstrative //
        if($employee->job->type == 'student')
        {
            //check if otp is same in plan
            if($request->otp != $appointment->otp)
            {
                return response(['status' => 0, 'msg' => 'Invail OTP'], 401);
            }
        }
        RegisteredEmployeeAttendandanceDepartureMethod::insert($registered_attend_depart_methods);
        DB::table('employee_plan_history')->insert($histroy);
        $employee_departure->save();
        return response()->json(
         [
             'status' => 1,
             'msg' => 'Success',
         ]
     );
     }
    }//end method



    function getEmployeeAppointments(Request $req)
    {
        $rules = array(
            'id' => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        $emp = Employee::find($req->id);
        if (!$emp) {
            return response()->json(['status' => 0, 'message' => 'the employee is not found', 404]);
        }
        $appointments = $emp->appointments;
        foreach ($appointments as $index => $appointment) {
            // check if today is not a workday
            $appointment['is_today_work_day'] = $appointment->isTodayWorkDay();
            $req->locations ? $appointment->locations : null;
            if ($req->branch_devices) {
                $appointment->branch->becon;
                $appointment->branch->wifi;
            }
        }
        return Response()->json(['status' => 1, 'message' => '__', 'data' => $appointments]);
    }//end method

    function Today_appointments(Request $request)
    {

        $rules = array(
            'emp_id' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $emp = Employee::find($request->emp_id);
        if (!$emp) {
            return response()->json(['status' => 0, 'message' => 'errors', 'errors' => [
                'employee' => 'the employee is not found'
            ]], 404);
        }


        return $emp->getEmployeeTodayAppointments();
    }

    // for developers //

    public function deleteAttendanceDeparture(Request $request)
    {
        $rules = array(
            'emp_id' => 'required',
            'appointment_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        //check if employee is found
        $employee = Employee::find($request->emp_id);
        if (!$employee) {
            return response()->json(['status' => 0, 'message' => 'No employee found'], 404);
        }

        //check if plan is found //
        $plan = Appointment::find($request->appointment_id);
        if (!$plan) {
            return response()->json(['status' => 0, 'message' => 'plan is not found'], 404);
        }
        //check if employee is assocated with plan //
        $assign_plan =  AssignAppointment::where('employee_id', $request->emp_id)->where('work_appointment_id', $request->appointment_id)->first();

        if (!$assign_plan) {
            return response()->json(['status' => 0, 'message' => 'Employee is not assocated with this plan'], 404);
        }

        $data = AttendanceAndDeparture::where('employee_id', $request->emp_id)
            ->where('appointment_id', $request->appointment_id)->first();
        if (!$data) {
            return response()->json(['status' => 0, 'message' => 'Attendance and Departure has been deleted'], 404);
        } else {
            $data = $data->delete();
            return response()->json(['status' => 1, 'msg' => 'deleted successfuly']);
        }
    }
}
