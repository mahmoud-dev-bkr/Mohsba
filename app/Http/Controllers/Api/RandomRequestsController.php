<?php

namespace App\Http\Controllers\api;

use App\Employee;
use App\Http\Controllers\Controller;
use App\RandomAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RandomRequestsController extends Controller
{

    public function updateRandomAttendance(Request $request)
    {
        $rules = array(
            'employee_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $randomAttendance = RandomAttendance::where('emp_id', $request->employee_id)
            ->where('date', Carbon::today())->latest()->first();
        // return $randomAttendance;

        $request_time = Carbon::parse($randomAttendance->created_at);
        // add limit to to responce //
        $maxRequestTime =  $request_time->addMinute($randomAttendance->period);
        $responce_time = Carbon::now();
        if ($randomAttendance) {
            if ($responce_time->lte($maxRequestTime)) {
                $randomAttendance->update([
                    'success' => '1'
                ]);
                return Response()->json(['status' => 1, 'message' => 'success']);
            } else {
                return Response()->json(['status' => 2, 'message' => 'Time Out For Responce']);
            }
        } else {
            return Response()->json(['status' => 0, 'message' => 'No Employee Found'], 404);
        }
    }

    public function updateFirebaseToken(Request $request)
    {
        $rules = array(
            'employee_id' => 'required',
            'firebase_token' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        // find employee

        $employee = Employee::find($request->employee_id);

        if ($employee) {
            $employee->update([
                'firebase_token' => $request->firebase_token
            ]);
            return response()->json(['status' => 1, 'message' => 'success', 'data' => $employee]);
        } else {
            return response()->json(['status' => 0, 'message' => 'Not Found'], 404);
        }
    }


    /**
     * test of api firebase notification
     */
    public function testFirebaseToken(Request $request)
    {
        $rules = array(
            'employee_id' => 'required',
        );

        $title_ar = 'حضور تلقاءي';
        $title_en = 'Randmom Attendance';
        $message_ar = 'برجاء عمل حضور الان';
        $message_en = 'Make Attendance Now';
        $result = Employee::notify($title_ar, $title_en,$message_ar, $message_en, 'default.png' ,$request->employee_id);
        return $result;
    }
}
