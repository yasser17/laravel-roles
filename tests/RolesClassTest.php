<?php

use Yasser\Roles\Models\Permission;
use Yasser\Roles\Models\Role;

class RolesClassTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->migrate();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    function test_can_attach_a_permission_to_role()
    {
        $role = new Role();
        $permission = new Permission();

        $role->attachPermission($permission);

        $this->assertTrue($role->permissions()->get()->contains($permission));
    }
}