<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchAttendanceMethod extends Model
{
protected $table = 'branch_attend_methods';
protected $fillable = [
    'branch_id' , 'attend_method_id' , 'active'
];
}
