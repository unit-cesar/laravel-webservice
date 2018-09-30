<?php

namespace App;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed roles
 */
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
     * @param $roleObj
     * @return array
     */
    public function hasRole($roleObj)
    {
        $userRoles = $this->roles;

        // dd($userRoles);
        // dd($roleObj);
        // dd($roleObj->intersect($userRoles)->count());
        return $roleObj->intersect($userRoles)->count();
    }


    /**
     * Add relationship between user and role
     * @param $role
     * @return int
     */
    public function addRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('id', '=', $role)->firstOrFail();
        }

        if ($this->checkRole($role)) {
            return 0;
        }

        // roles() -> é um metodo do Model User
        return $this->roles()->attach($role);
    }

    /**
     * Check if role already has relationship to user
     * @param $role
     * @return bool
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
     * @param $role
     * @return int
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
