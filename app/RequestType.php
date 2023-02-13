<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    //
    protected $table = 'request_type';
    protected $fillable = [
        'name', 'note', 'created_at', 'updated_at'
    ];
}
