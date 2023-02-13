<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmployeeRequest extends Model
{
    use Notifiable;
    protected $table = "EmployeeRequest";
    protected $fillable = [
        'employee_id', 'user_id', 'request_type_id', 'request', 'date', 'created_at', 'updated_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    //one-to-many relationship
    public function request_type()
    {
        return $this->belongsTo(RequestType::class, 'request_type_id');
    }
    //one-to-many relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
