<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceAndDeparture extends Model
{
    //
    protected $table = 'attendance_and_departure';
    protected $fillable = [
        'employee_id',
        'branch_id',
        'date',
        'appointment_id',
        'attend_time_p1',
        'depart_time_p1',
        'attend_time_p2',
        'depart_time_p2',
        'attend_state_p1',
        'depart_state_p1',
        'attend_state_p2',
        'depart_state_p2',
        'attend_reason_p1',
        'attend_reason_p2',
        'depart_reason_p1',
        'depart_reason_p2',
        'overtime_minutes',
        'user_id',
        'absence',
        'absence_with_permission',
        'absence_with_vacation',
        'late',
        'late_with_permission',
        'leave_with_permission',
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
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
