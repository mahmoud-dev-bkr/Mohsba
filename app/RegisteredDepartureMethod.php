<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredDepartureMethod extends Model
{
    protected $table = "registered_employees_departure_methods";
    protected $fillable = [
        'employee_id' , 
        'attend_mthod_id', 
        'plan_id',
        'location_id',
        'state',
        'departure_id'
    ];
}
