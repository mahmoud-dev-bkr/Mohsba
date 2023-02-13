<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vication extends Model
{
    //
    protected $table = 'vications';
    protected $fillable = [
        'week_day_id', 'attendance_setting_id'
    ];
}
