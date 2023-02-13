<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePermission extends Model
{
    //
    protected $table = 'employee_permission_to_leave';
    protected $fillable = [
        'employee_id',
        'plan_id',
        'date',
        'notes',
        'created_at',
        'updated_at'
    ];
    // one to many with employee //
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function plan()
    {
        return $this->belongsTo(Appointment::class, 'plan_id');
    }
}
