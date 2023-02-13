<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobCategory extends Model
{
    //
    use Notifiable;
    protected $table = 'job_categories';
    protected $fillable = [
        'name', 'description','job_category_id','created_at', 'updated_at'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
