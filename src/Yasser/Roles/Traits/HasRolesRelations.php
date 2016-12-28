<?php
namespace Yasser\Roles\Traits;

use Yasser\Roles\Models\Permission;
use Yasser\Roles\Models\Role;

trait HasRolesRelations
{
    public function roles()
    {
        return $this->belongsToMany(config('roles.role', Role::class));
    }

    /**
     * Check if the user has a role
     *
     * @param Role $role
     * @return bool
     */
    public function hasRole(Role $role)
    {
        return $this->roles()->get()->contains($role);
    }

    /**
     * Method to attach a role to a User
     *
     * @param Role $role
     * @return bool|void
     */
    public function attachRole(Role $role)
    {
        return !$this->hasRole($role) ? $this->roles()->attach($role) : true;
    }

    /**
     * Detach a role from a user
     *
     * @param Role $role
     * @return bool|int
     */
    public function detachRole(Role $role)
    {
        return $this->hasRole($role) ? $this->roles()->detach($role) : true;
    }

    /**
     * Attach many roles to a User
     *
     * @param array $roles
     */
    public function attachRoles(array $roles)
    {
        foreach ($roles as $role) {
            if ($role instanceof Role) {
                !$this->hasRole($role) ? $this->roles()->attach($role) : true;
            }
        }
    }

    /**
     * Detach many roles from a user
     *
     * @param array $roles
     */
    public function detachRoles(array $roles)
    {
        foreach ($roles as $role) {
            if ($role instanceof Role) {
                $this->hasRole($role) ? $this->roles()->detach($role) : true;
            }
        }
    }

    public function canDo($key)
    {
        $permission = Permission::with('roles.permissions')
            ->whereHas('roles.permissions', function($query) use ($key) {
                $query->where('slug', $key);
            })->first();

        return $permission ? true : false;
    }
}