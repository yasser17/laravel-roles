<?php
namespace Yasser\Roles\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //TODO: a partir de aca se va ir todo al trait

    public function roles()
    {
        return $this->belongsToMany(config('roles.role'), '\Yasser\Roles\Models\Role');
    }

    /**
     * Method to attach a role to a User
     *
     * @param Role $role
     * @return bool|void
     */
    public function attachRole(Role $role)
    {
        return !$this->roles()->get()->contains($role) ? $this->roles()->attach($role) : true;
    }

}