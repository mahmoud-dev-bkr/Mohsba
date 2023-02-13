<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Branch extends Model
{
    //
    use NodeTrait;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'notes',
        'long',
        'lat',
        'latitude',
        'longituide'
    ];


    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
    public function employees()
    {
        return $this->hasMany("App\Employee");
    }
    public function assigned_appointments()
    {
        return $this->hasMany(AssignAppointment::class);
    }
    public function attendance_settings()
    {
        return $this->hasOne(AttendenceSetting::class);
    }
    public function branch_settings()
    {
        return $this->hasOne(BranchSetting::class);
    }
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    // return array of wifi devices
    public function wifi()
    {
        return $this->devices()->where('type', 'wifi');
    }
    // return array of becon devices
    public function becon()
    {
        return $this->devices()->where('type', 'becon');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function attendance_methods()
    {
        return $this->belongsToMany(Attendancemethod::class, 'branch_attend_methods', 'branch_id', 'attend_method_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($branch) {
            $relationMethods = ['employees', 'users', 'appointment', 'assigned_appointments', 'locations'];
            foreach ($relationMethods as $relationMethod) {
                if ($branch->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
