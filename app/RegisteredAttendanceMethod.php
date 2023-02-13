<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredAttendanceMethod extends Model
{
    protected $table = "registered_employees_attendance_methods";
    protected $fillable = [
        'employee_id',
        'attend_mthod_id',
        'plan_id',
        'location_id',
        'state',
        'attendance_id',
        'created_at',
        'updated_at',
    ];
}
