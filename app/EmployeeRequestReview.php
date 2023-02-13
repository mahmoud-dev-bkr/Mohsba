<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequestReview extends Model
{
    //
    protected $table = 'employee_request_review';
    protected $fillable = [
        'id', 'employee_id', 'request', 'details', 'date', 'created_at', 'updated_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
