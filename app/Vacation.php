<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    //
    protected $table = 'vications';
    protected $fillable = [
        'date',
        'reason',
        'created_at',
        'updated_at',
    ];
}
