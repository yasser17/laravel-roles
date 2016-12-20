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
        return $this->belongsToMany(User::class);
    }

    public function attachPermission(Permission $permission)
    {
        if($permission) {
            return !$this->permissions()->get()->contains($permission) ?
                $this->permissions()->attach($permission) : true;
        }

    }

    public function attachPermissions(array $permissions = [])
    {
        if (isset($permissions[0])) {
            foreach ($permissions as $permission) {
                if ($permission instanceof Permission)
                {
                    !$this->permissions()->get()->contains($permission) ? $this->permissions()->attach($permission) : true;
                }
            }
        }
    }
}