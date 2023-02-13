<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredEmployeeAttendandanceDepartureMethod extends Model
{
    //
    protected $table = 'register_employee_attend_and_departs_methods';
    protected $fillable = [
        'employee_id',
        'attendance_id',
        'departure_id',
        'period',
        'attend_method_id',
        'plan_id',
        'location_id',
        'state',
        'created_at',
        'updated_at',
    ];

    public function attendanceMethod()
    {
        return $this->belongsTo(Attendancemethod::class,'attend_method_id');
    }
}
