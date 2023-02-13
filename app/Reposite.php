<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reposite extends Model
{
    //
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];


    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }


    public function loans()
    {
        return $this->hasMany('App\Models\Loan');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction','to_id');
    }

    
}
