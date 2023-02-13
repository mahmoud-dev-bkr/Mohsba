<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    //
    protected $table = 'employee_attendance';
    protected $fillable = [
        'employee_id',
        'branch_id',
        'appointment_id',
        'departure_time',
        'statue',
        'user_name',
        'date',
        'created_at',
        'updated_at',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function registered_attendance_method()
    {
        return $this->belongsToMany(Attendancemethod::class, 'registered_employees_attendance_methods', 'attendance_id', 'attend_mthod_id');
        // return $this->belongsToMany(Attendancemethod::class, 'employee_attend_methods', 'employee_id', 'attend_method_id');

    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
