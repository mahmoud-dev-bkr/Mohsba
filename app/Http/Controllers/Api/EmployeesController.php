<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Utils\Util;

class EmployeesController extends Controller
{

    public function employeeLogin(Request $request)
        {
            $rules = array(
                'username' => 'required',
                'password' => 'required',
                'mobile_mac_address'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
            }
            $username = $request->username;
            $password = $request->password;
            $mobile_mac_address = $request->mobile_mac_address;

            $employee = Employee::where('username', $username)
            ->orWhere('job_number', $username)
            ->with(['appointments.locations', 'appointments.branch.becon:branch_id,code', 'appointments.branch.wifi:branch_id,ssid,bssid'])
            ->first();

            if (!$employee) {
                return Response()->json(['status' => 0, 'message' => 'Invalid username or password']);
            }
            if($employee->mobile_mac_address && $mobile_mac_address  != $employee->mobile_mac_address)
            {
                return Response()->json(['status' => 2, 'message' => 'Invalid Mobile Mac Address']);
            }
            $employee['type'] = $employee->job->type;
            $employee['attend_methods'] = DB::table('employee_attend_methods')
            ->join('attend_methods', 'attend_methods.id', '=', 'employee_attend_methods.attend_method_id')
            ->where([['employee_id' , $employee->id] , ['active' , 1]])
            ->select(['name' , 'attend_methods.id' , 'optional'])
            ->get();
            if (!$employee->password) {
                // check with job number
                if ($employee->job_number != $password) {
                    return Response()->json(['status' => 0, 'message' => 'Invalid username or password']);
                }
            } else {
                // check with password
                if (!Hash::check($password, $employee->password)) {
                    return Response()->json(['status' => 0, 'message' => 'Invalid username or password']);
                }
            }

            // the employee passed the authentication

            return Response()->json(['status' => 1, 'message' => 'success', 'data' => $employee]);
        }


    public function getData(Request $request)
    {
        $data =  Employee::latest()->get();
        return Response()->json(['status' => 1, 'message' => 'success', 'data' => $data]);
    }

    function isEmployeePhoneExist(Request $request)
    {

        $rules = array(
            'phone' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        $phone = $request->phone;

        $employee = Employee::where('phone', $phone)->first();

        if ($employee) {
            return Response()->json(['status' => 1, 'message' => 'success Your Phone is Exist' , 'data' => $employee]);
        } else {
            return Response()->json(['status' => 0, 'message' => 'this phone number doesn\'t exist in our records'], 404);
        }
    }

    function isOtpTrue(Request $request)
    {

        $rules = array(
            'otp' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        $otp = $request->otp;

        $employee = Employee::where('otp', $otp)->first();

        if ($employee) {
            return Response()->json(['status' => 1, 'message' => 'success Your OTP is Exist']);
        } else {
            return Response()->json(['status' => 0, 'message' => 'Invalid OTP'], 401);
        }
    }
    function resetPassword(Request $request)
    {

        $rules = array(
            'id' => 'required',
            'password' => 'required',
            're_password' => 'required',
            'mobile_mac_address'=>'required|unique:employees'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        if ($request->password == $request->re_password) {
            $employee = Employee::find($request->id);
            $employee->update([
                'password' => Hash::make($request->password),
                'mobile_mac_address'=>$request->mobile_mac_address
            ]);
            return Response()->json(['status' => 1, 'message' => 'success Your password and Mobile Mac address is changed']);
        } else {
            return Response()->json(['status' => 0, 'message' => 'password not equal Re-Password']);
        }
    }

    function forgetPassword(Request $request)
    {

        $rules = array(
            'phone' => 'required',
            'mobile_mac_address' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
            $employee = Employee::where('phone', $request->phone)->where('mobile_mac_address', $request->mobile_mac_address)->first();
            if($employee){

                $util = new Util();

                $otp = $util->sendSMS($employee->phone, 'employee');

                return Response()->json(['status' => 1, 'message' => 'success', 'otp'=>$otp]);

            }else{
                return Response()->json(['status' => 0, 'message' => 'invalid data']);

            }


    }
    function changePassword(Request $request)
    {

        $rules = array(
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        try {
            $employee = Employee::FindOrFail($request->id);
            //  check old password
            if (!Hash::check($request->old_password, $employee->password)) {
                return Response()->json(['status' => 0, 'message' => 'the old password is not correct'], 403);
            }

            $employee->update([
                'password' => Hash::make($request->new_password)
            ]);
            return Response()->json(['status' => 1, 'message' => 'success Your password is changed']);
        } catch (\Exception $e) {
            return Response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    function employeeUpdate(Request $request)
    {

        $rules = array(
            'id' => 'required',
            'name' => '',
            'email' => '',
            'avatar' => '',
            'phone' => '',
            'phone_num2' => '',
            'address' => '',
            'gender' => '',
            'age' => '',
            'has_voice' => '',
            'has_image' => '',
            'has_finger' => ''
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }
        $request_data = $validator->validate();

        $employee = Employee::find($request->id);

        if ($employee) {

            $avatar = $request->avatar;
            if ($avatar) {
                $image = implode(array_map('chr', $avatar));
                $filename    = $employee->id . '-' . 'avatar.png';
                $destinationPath = public_path('/uploads/avatars');
                file_put_contents($destinationPath.'/'.$filename,$image);
                $employee['avatar'] = URL::to('/').'/public/uploads/avatars/' . $filename;
            }

            $employee->update($request_data);
            return Response()->json(['status' => 1, 'message' => 'Data updated successfuly', 'data' => $employee]);
        } else {
            return Response()->json(['status' => 0, 'message' => 'No employee found'], 404);
        }
    }

    function get_employee_attendenceMethods(Request $req)
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
        $data = DB::table('employee_attend_methods')
        ->join('attend_methods', 'attend_methods.id', '=', 'employee_attend_methods.attend_method_id')
        ->where([['employee_id' , $emp->id] , ['active' , 1]])
        ->select(['name' , 'attend_methods.id' , 'optional'])
        ->get();

        return Response()->json(['status' => 1, 'message' => '__', 'data' => $data]);
    }

    function getEmployeeData(Request $req)
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

        return Response()->json(['status' => 1, 'message' => '__', 'data' => $emp]);
    }

    // will be removed later
    function make_null(Request $req)
    {
        $id = $req->id;
        $emp = Employee::find($id);
        $emp->update([
            'password' => null
        ]);

        return 'done';
    }

      // for developers  //
      function Loginwithid(Request $request)
      {
          $rules = array(
              'emp_id'=>'required'
          );
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
          }
          $emp_id = $request->emp_id;


          $employee = Employee::where('id', $emp_id)->with(['appointments.locations', 'appointments.branch.becon:branch_id,code', 'appointments.branch.wifi:branch_id,ssid,bssid'])->first();

          $employee['attend_methods'] = DB::table('employee_attend_methods')
                              ->join('attend_methods', 'attend_methods.id', '=', 'employee_attend_methods.attend_method_id')
                              ->where([['employee_id' , $employee->id] , ['active' , 1]])
                              ->select(['name' , 'attend_methods.id' , 'optional'])
                              ->get();

          if (!$employee) {
              return Response()->json(['status' => 0, 'message' => 'Invalid username or password']);
          }

          // the employee passed the authentication

          return Response()->json(['status' => 1, 'message' => 'success', 'data' => $employee]);
      }

      //update has image and has voice to zero //

      public function deleteImageAndVoice(Request $request)
      {
        $rules = array(
            'emp_id'=>'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $employee = Employee::find($request->emp_id);
        if(!$employee)
        {
            return response()->json(['statue'=>0,'message' => 'Employee is not found'],404);
        }
        if($employee->has_image == true)
        {
            $isupdated = $employee->update([
                'has_image'=>'0',
                'has_voice'=>'0',
                'has_finger'=>'0'
            ]);
            if($isupdated)
            {
                return response()->json(['status' => 1, 'msg' => 'Deleted successfuly']);
            }
        }else{
            return response()->json(['status' => 0, 'msg' => 'Has been deleted'],404);
        }

      }
      ///////////////end////////////////
    
      public function CheckForgetenPassword(Request $request)
      {

        $rules = array(
            'otp' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $employee = Employee::where('otp',$request->otp)->first();
        if($employee)
        {
            return Response()->json(['status' => 1, 'message' => 'success']);
        }
        else{
            return response()->json(['status' => 0, 'msg' => 'Invaild Otp'],401);
        }
      }

    
}
