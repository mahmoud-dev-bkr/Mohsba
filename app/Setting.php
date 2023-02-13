<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "company_settings";

    protected $fillable = [
        'id', 'name',    'value'
    ];
}
