<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Add relationship between role and permission
     * @param $perm
     * @return array
     */
    public function addPerm($perm)
    {

        if (is_string($perm)) {
            $perm = Permission::where('id', '=', $perm)->firstOrFail();
        }

        if ($this->checkPerm($perm)) {
            return [];
        }

        // roles() -> é um metodo do Model User
        return $this->permissions()->attach($perm);
    }

    /**
     * Check if permission already has relationship to role
     * @param $perm
     * @return bool
     */
    public function checkPerm($perm)
    {
        // if (is_string($perm)) {
        //     $perm = Permission::where('id', '=', $perm)->firstOrFail();
        // }

        return (boolean)$this->permissions()->find($perm->id);

    }

    /**
     * Removes relationship between role and permission
     * @param $perm
     * @return int
     */
    public function removePerm($perm)
    {
        if (is_string($perm)) {
            $perm = Permission::where('id', '=', $perm)->firstOrFail();
        }

        return $this->permissions()->detach($perm);
    }
}
