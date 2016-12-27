<?php

namespace Yasser\Roles;

use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__. '/../config/config.php' => config_path() . 'config/roles.php'
        ]);
    }
}