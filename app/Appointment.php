<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    //
    use Notifiable;
    protected $table = 'work_appointments';
    protected $fillable = [
        'name', 'attendance_plan_type_id', 'location_id', 'start_from_period_1', 'end_to_period_1', 'start_from_period_2', 'end_to_period_2', 'delay_period_1', 'delay_period_2', 'branch_id', 'overtime', 'date', 'otp', 'created_at', 'updated_at', 'attendance_days'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function getDevicesIdsAttribute()
    {
        return $this->devices()->pluck('device_id');
    }
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'appointments_devices', 'appointment_id', 'device_id');
    }
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'appointments_locations', 'appointment_id', 'location_id');
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'assign_appointments', 'work_appointment_id', 'employee_id');
    }
    public function getEmployeesIds()
    {
        return $this->employees()->pluck('employee_id');
    }
    public function attendance_plan_type()
    {
        return $this->belongsTo(AttendancePlanType::class, 'attendance_plan_type_id');
    }
    public function isTodayWorkDay()
    {
        $today = Carbon::today()->dayOfWeek + 2;
        if ($today > 7) $today = 1;
        return in_array((string)$today, explode(',', $this->attendance_days));
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($job) {
            $relationMethods = ['employees'];

            foreach ($relationMethods as $relationMethod) {
                if ($job->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
