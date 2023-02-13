<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $table = 'business';
    protected $fillable =[
        'name',
        'description',
        'created_at',
        'updated_at'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($business) {
            $relationMethods = ['employees'];
            foreach ($relationMethods as $relationMethod) {
                if ($business->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
