<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $table = 'roles';

    protected $fillable = [
          'name' ,'notes' , 'created_at' , 'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "role_user");
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
