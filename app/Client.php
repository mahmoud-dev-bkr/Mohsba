<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'pointsClient',
        'theCondition',
        'Tex_Number',
        'webName',
        'Facility',
        'email2',
        'email',
        'phon2',
        'phon',
        'status',
    ];

}
