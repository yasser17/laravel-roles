<?php

namespace Yasser\Roles;

use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('config/roles.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/roles.php', 'roles'
        );
    }

    public function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->directive('canDo', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->canDo({$expression}): ?>";
        });

        $blade->directive('endCanDo', function ($expression) {
            return "<?php endif; ?>";
        });
    }
}