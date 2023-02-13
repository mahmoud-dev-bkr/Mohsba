<?php

namespace App\Http\Controllers;

use App\EmployeePermission;
use Illuminate\Http\Request;

class EmployeePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('employee_permission_to_leave.index');
        // $employee_permission = EmployeePermission::query();

        // $data = Datatables()->eloquent($employee_permission)
        //     ->addColumn('employee_name', function (EmployeePermission $employee_permission) {
        //         return $employee_permission->employee->name;
        //     })
        //     ->toJson();
        // return $data;
    }

    public function getData()
    {
        $employee_permission = EmployeePermission::query();

        $data = Datatables()->eloquent($employee_permission)
            ->addColumn('employee_name', function (EmployeePermission $employee_permission) {
                return $employee_permission->employee->name;
            })
            ->toJson();
        return $data;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
