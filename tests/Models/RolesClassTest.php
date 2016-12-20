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
        $role = $this->createAdminRole();

        $permission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);


        $role->attachPermission($permission);

        $this->assertTrue($role->permissions()->get()->contains($permission));
    }

    function test_can_attach_permissions_array()
    {
        $role = $this->createAdminRole();

        $createPermission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $editPermission = Permission::create([
            'name' => 'Edit user',
            'slug' => 'users.edit'
        ]);

        $role->attachPermissions([$createPermission, $editPermission]);

        $this->assertTrue($role->permissions()->get()->contains($createPermission));
        $this->assertTrue($role->permissions()->get()->contains($editPermission));
    }

}