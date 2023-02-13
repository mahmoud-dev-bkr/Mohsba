<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;

    use Notifiable;
    protected $table = "users";
    protected $fillable = [
        'name', 'email', 'address', 'phone', 'branch_id', 'role_id', 'password', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class)->first;
    }

    // public function hasRole($role)
    // {
    //     if(is_string($role)) {
    //         return $this->role->contains('name' , $role);
    //     }
    
    //     return !! $role->intersect($this->role)->count();
    // }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
