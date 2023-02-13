<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Location extends Model
{
    //
    use Notifiable;
    protected $table = 'locations';

    protected $fillable = ['name', 'branch_id', 'location_address', 'boundary_radius', 'location_latitude', 'location_longituide', 'notes', 'created_at', 'updated_at', 'device_id'];

 
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
  
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($location) {
            $relationMethods = ['appointment'];

            foreach ($relationMethods as $relationMethod) {
                if ($location->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
