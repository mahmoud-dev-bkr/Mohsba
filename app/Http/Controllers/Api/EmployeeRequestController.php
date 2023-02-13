<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\EmployeeRequestReview;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;


class EmployeeRequestController extends Controller
{
    public function getData(Request $request)
    {
        $rules = array(
            'id' => 'required',
        );
        $per_page = $request->per_page ?: 10;


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()], 400);
        }

        $data =  EmployeeRequestReview::where('employee_id', $request->id)->orderBy('id', 'DESC')->paginate($per_page);
        return Response()->json(['status' => 1, 'message' => 'success', 'data' => $data]);
    }

    function create_byte_array($string)
    {
        $array = array();
        foreach (str_split($string) as $char) {
            array_push($array, sprintf("%02X", ord($char)));
        }
        return implode(' ', $array);
    }

    function store(Request $request)
    {
        try {
            $rules = array(
                'id' => 'required',
                'title' => 'required',
                'details' => 'required',
                'attachment' => ''
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response()->json(['status' => 0, 'message' => 'errors', 'errors' => $validator->getMessageBag()->toArray()], 400);
            }
            $request_data = $request->all();

            $employee = Employee::find($request->id);

            if ($employee) {
                $emp_request = new EmployeeRequestReview();
                $emp_request['employee_id'] = $employee->id;
                $emp_request['request'] = $request_data['title'];
                $emp_request['details'] = $request_data['details'];
                $emp_request['date'] = date('y-m-d');

                // expected to be a byte array 

                $attachment = $request->attachment;
                if ($attachment) {
                    $image = implode(array_map('chr', $attachment));
                    $filename    = 'attachment-' . time() . '.png';
                    $destinationPath = public_path('/uploads/requests');
                    file_put_contents($destinationPath . '/' . $filename, $image);
                    // $img->resize(500, 500, function ($constraint) {
                    //     $constraint->aspectRatio();
                    // })->save($destinationPath . '/' . $filename);

                    $emp_request['attachment'] = URL::to('/') . '/public/uploads/requests/' . $filename;
                }

                $emp_request->save();
                return Response()->json(['status' => 1, 'message' => 'Data added successfuly', 'data' => $emp_request]);
            } else {
                return Response()->json(['status' => 0, 'message' => 'no employee found'], 404);
            }
        } catch (Exception $e) {
            return Response()->json(['status' => 0, 'message' => $e->getMessage()], 500);
        }
    }
}
