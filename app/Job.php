<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    //
    use Notifiable;
    protected $fillable = [
        'name', 'notes', 'job_category_id', 'type' , 'created_at', 'updated_at'
    ];

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function assigned_appointments()
    {
        return $this->hasMany(AssignAppointment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($job) {
            $relationMethods = ['employees', 'assigned_appointments'];

            foreach ($relationMethods as $relationMethod) {
                if ($job->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
