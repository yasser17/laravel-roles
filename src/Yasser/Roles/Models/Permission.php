<?php
namespace Yasser\Roles\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The attribute to mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'model'];

    /**
     * Permission belongs to many roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('roles.role', Role::class));
    }

    /**
     * Permission belongs to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model', config('auth.model')));
    }
}