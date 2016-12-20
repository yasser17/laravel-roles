<?php
namespace Yasser\Roles\Models;

use Illuminate\Contracts\Auth\UserProvider as User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * Role belongs to many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
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
        return !$this->permissions()->get()->contains($permission) ?
            $this->permissions()->attach($permission) : true;
    }
}