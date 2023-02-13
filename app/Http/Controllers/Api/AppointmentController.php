<?php

namespace App\Http\Controllers\Api;

use App\Branch;
use App\Employee;
use App\Attendancemethod;
use App\Appointment;
use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    public function updateOtp()
    {

        try {
            $appointment =  Appointment::where('id', request()->work_appointment_id)->first();
            if ($appointment) {
                $appointment->update([
                    'otp' => rand(11111, 99999)
                ]);
                $otp = $appointment->otp;
            }
            return Response()->json(['status' => 1, 'message' => 'success', 'otp' => $otp]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
