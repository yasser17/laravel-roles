<?php
namespace Yasser\Roles\Models;

use Illuminate\Contracts\Auth\UserProvider as User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The attribute to mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'model'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * Permission belongs to many roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Permission belongs to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}