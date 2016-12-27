<?php

use Orchestra\Testbench\TestCase as BaseTestCase;
use Yasser\Roles\Models\Role;
use Yasser\Roles\Models\User;

class TestCase extends BaseTestCase
{
    protected $adminRole;

    protected $defaultUser;

    public function setUp()
    {
        parent::setUp();

        $this->migrate();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

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

    /**
     * This method returns a default user
     *
     * @return User
     */
    public function createDefaultUser()
    {
        if ($this->defaultUser) {
            return $this->defaultUser;
        }

        return $this->defaultUser = User::create([
            'name' => 'Yasser Mussa',
            'email' => 'yasser.mussa@gmail.com',
            'password' => bcrypt('secret')
        ]);
    }
}