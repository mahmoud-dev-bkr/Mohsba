<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Attendancemethod extends Model
{
    use Notifiable;
    protected $table = "attend_methods";
    protected $fillable = [
        'name', 'active', 'notes', 'created_at', 'updated_at'
    ];
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_attend_methods', 'employee_id', 'attend_method_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($employees) {
            $relationMethods = ['employees'];

            foreach ($relationMethods as $relationMethod) {
                if ($employees->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
