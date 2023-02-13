<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDeparture extends Model
{
    protected $table = 'employees_departure';
    protected $fillable = [
        'employee_id',
        'branch_id',
        'appointment_id',
        'attendance_method_id',
        'state',
        'reason',
        'user_name',
        'date',
        'period',
        'overtime',
        'created_at',
        'updated_at'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function registered_departure_method()
    {
        return $this->belongsToMany(Attendancemethod::class, 'registered_employees_departure_methods', 'departure_id', 'attend_mthod_id');
    }
}
