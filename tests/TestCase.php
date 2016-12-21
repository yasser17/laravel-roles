<?php

use Orchestra\Testbench\TestCase as BaseTestCase;
use Yasser\Roles\Models\Role;

class TestCase extends BaseTestCase
{
    protected $adminRole;

    protected function getEnvironmentSetUp($app)
    {
        $config = $app['config'];

        // Laravel App Configs
        $config->set('database.default', 'testing');
        $config->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            \Yasser\Roles\RolesServiceProvider::class
        ];
    }

    /**
     * Migrate the migrations.
     */
    protected function migrate()
    {
        $this->artisan('migrate', [
            '--database' => 'testing',
            '--realpath' => $this->getMigrationsSrcPath(),
        ]);
    }

    /**
     * Return a admin role
     *
     * @return Role
     */
    protected function getMigrationsSrcPath()
    {
        return realpath(dirname(__DIR__) . '/src/Yasser/migrations');
    }

    /**
     * Create a admin role
     *
     * @return Role
     */
    public function createAdminRole()
    {
        if ($this->adminRole) {
            return $this->adminRole;
        }

        return $this->adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);
    }
}