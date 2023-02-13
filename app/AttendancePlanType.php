<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendancePlanType extends Model
{
    //
    protected $table = 'attendance_plan_types';
    protected $fillable = [
        'id', 'name'
    ];
}
