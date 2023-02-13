<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RandomAttendance extends Model
{
    //
    protected $table = 'random_request';
    protected $fillable = [
        'emp_id',
        'period',
        'time',
        'date',
        'user_id',
        'success',
        'branch_id',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['created_at', 'updated_at'];
    public function employees()
    {
        return $this->belongsTo(Employee::class,'emp_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function plan()
    {
        return $this->belongsTo(Appointment::class,'plan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    
}
