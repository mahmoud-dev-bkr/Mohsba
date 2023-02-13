<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AttendancePlanDetail extends Model
{
    //
    use Notifiable;
    protected $table = 'attendance_plan_details';
    protected $fillable = [
        'work_appointment_id', 'start_date', 'end_date', 'created_at', 'updated_at', 'overtime', 'delay_period_1', 'delay_period_2', 'attendance_days'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'work_appointment_id');
    }
}
