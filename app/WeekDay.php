<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekDay extends Model
{
    //
    protected $table = 'week_days';
    protected $fillabel = [
        'id', 'days'
    ];
}
