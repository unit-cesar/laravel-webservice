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

    /**
     * Checks if permission belongs to the role
     *
     */
    public function hasRole($roles)
    {
        $userRoles = $this->roles;

        // dd($userRoles);
        // dd($roles);
        // dd($roles->intersect($userRoles)->count());
        return $roles->intersect($userRoles)->count();
    }


    /**
     * Add relationship between user and role
     *
     */
    public function addRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('id', '=', $role)->firstOrFail();
        }

        if ($this->checkRole($role)) {
            return;
        }

        // roles() -> é um metodo do Model User
        return $this->roles()->attach($role);
    }

    /**
     * Check if role already has relationship to user
     *
     */
    public function checkRole($role)
    {
        // if (is_string($role)) {
        //     $role = Role::where('id', '=', $role)->firstOrFail();
        // }

        return (boolean)$this->roles()->find($role->id);
    }

    /**
     * Removes relationship between user and role
     *
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('id', '=', $role)->firstOrFail();
        }

        // roles() -> é um metodo do Model User
        return $this->roles()->detach($role);
    }

}
