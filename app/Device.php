<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Device extends Model
{
    use Notifiable;
    protected $fillable = [
        'type' ,'ssid', 'bssid','branch_id', 'code', 'notes', 'created_at', 'updated_at' 
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class , 'branch_id');
    }

    public function device_name(){
        return $this->type == 'wifi' ? 'wifi-(ssid)'.$this->ssid.'-(bssid)'.$this->bssid : 'becon-(code)'.$this->code;
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($device) {
            $relationMethods = ['locations'];

            foreach ($relationMethods as $relationMethod) {
                if ($device->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
