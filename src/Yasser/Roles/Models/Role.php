<?php
namespace Yasser\Roles\Models;

use Illuminate\Contracts\Auth\UserProvider as User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Role belongs to many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('roles.permission', Permission::class));
    }

    /**
     * Role belongs to many user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model', config('auth.model')));
    }

    /**
     * Attach a permission to a Role
     *
     * @param Permission $permission
     * @return bool|void
     */
    public function attachPermission(Permission $permission)
    {
        return !$this->permissions()->get()->contains($permission) ?
            $this->permissions()->attach($permission) : true;
    }

    /**
     * Attach many permissions to a role
     *
     * @param array $permissions
     */
    public function attachPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($permission instanceof Permission)
            {
                !$this->permissions()->get()->contains($permission) ? $this->permissions()->attach($permission) : true;
            }
        }
    }

    /**
     * Detach a permission from a role
     *
     * @param Permission $permission
     * @return bool|int
     */
    public function detachPermission(Permission $permission)
    {
        return $this->permissions()->get()->contains($permission) ?
            $this->permissions()->detach($permission) :
            true;
    }

    /**
     * Detach many permissions from a role
     *
     * @param array $permissions
     */
    public function detachPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($permission instanceof Permission)
            {
                $this->permissions()->get()->contains($permission) ? $this->permissions()->detach($permission) : true;
            }
        }
    }
}