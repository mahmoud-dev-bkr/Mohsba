<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AttendenceSetting extends Model
{
    protected $table = "attendance_settings";
    protected $fillable = [
        'branch_id', 'allow_deny', 'automatic_leave', 'over_time_count', 'attendance_time', 'work_days', 'allowance_time', 'work_hours', 'validate_finger', 'created_at', 'updated_at'
    ];

    public function getAttendanceTimeAttribute()
    {
        return Carbon::parse($this->attributes['attendance_time']);
    }
    //
}
