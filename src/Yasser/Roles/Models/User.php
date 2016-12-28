<?php
namespace Yasser\Roles\Models;

use ClassPreloader\Config;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Yasser\Roles\Traits\HasRolesRelations;

class User extends Authenticatable
{
    use Notifiable, HasRolesRelations;

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

}
