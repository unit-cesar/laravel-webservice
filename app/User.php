<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function isSuperUser()
    {
        $role = Role::where('name', '=', 'SuperUser')->firstOrFail();
        return (boolean)$this->roles()->find($role->id);
    }

    public function hasRole($roles)
    {
        $userRoles = $this->roles;

        // dd($userRoles);
        // dd($roles);
        // dd($roles->intersect($userRoles)->count());
        return $roles->intersect($userRoles)->count();
    }
}
