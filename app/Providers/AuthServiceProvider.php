<?php

namespace App\Providers;
use App\Role;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();


        if (! app()->runningInConsole()) {
            $roles = Role::with('permission')->get();
            $permissionArray = [];
            foreach ($roles as $role) {
                foreach ($role->permission as $permission) {
                    $permissionArray[$permission->name][] = $role->id;
                }
            }

            foreach ($permissionArray as $name => $roles) {
                Gate::define($name, function (User $user) use ($roles) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roles));
                });
            }
        }
    }
}
