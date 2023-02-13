<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraTime extends Model
{
    //
    protected $table = 'extra_time';
    protected $fillable = [
        'branch_id', 'attendance_setting_id', 'employee_id', 'time_count', 'created_at', 'updated_at'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
