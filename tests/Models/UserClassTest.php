<?php

class UserClassTest extends TestCase
{
    function test_a_user_has_a_role()
    {
        $user = $this->createDefaultUser();

        $role = $this->createAdminRole();

        $user->attachRole($role);

        $this->assertTrue($user->hasRole($role));
    }

    function test_a_user_does_not_have_a_role()
    {
        $user = $this->createDefaultUser();

        $role = $this->createAdminRole();

        $this->assertFalse($user->hasRole($role));
    }

    function test_can_attach_a_role_to_a_user()
    {
        $user = $this->createDefaultUser();
        $role = $this->createAdminRole();

        $user->attachRole($role);

        $this->assertTrue($user->hasRole($role));
    }

    function test_can_detach_a_role_from_a_user()
    {
        $user = $this->createDefaultUser();

        $role = $this->createAdminRole();

        $user->detachRole($role);

        $this->assertFalse($user->hasRole($role));
    }

    function test_can_attach_many_roles_to_a_user()
    {
        $user = $this->createDefaultUser();

        $roleAdmin = $this->createAdminRole();

        $roleOperator = \Yasser\Roles\Models\Role::create([
            'name' => 'Operator',
            'slug' => 'operator'
        ]);

        $user->attachRoles([
            $roleAdmin, $roleOperator
        ]);

        $this->assertTrue($user->hasRole($roleAdmin));
        $this->assertTrue($user->hasRole($roleOperator));
    }

    function test_can_detach_many_roles_from_a_user()
    {
        $user = $this->createDefaultUser();

        $roleAdmin = $this->createAdminRole();

        $roleOperator = \Yasser\Roles\Models\Role::create([
            'name' => 'Operator',
            'slug' => 'operator'
        ]);

        $user->attachRoles([
            $roleAdmin, $roleOperator
        ]);

        $user->detachRoles([
            $roleAdmin,
            $roleOperator
        ]);

        $this->assertFalse($user->hasRole($roleAdmin));
        $this->assertFalse($user->hasRole($roleOperator));
    }

    function test_if_user_has_a_permission_slug()
    {
        $user = $this->createDefaultUser();
        $role = $this->createAdminRole();
        $permission = \Yasser\Roles\Models\Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $role->attachPermission($permission);
        $user->attachRole($role);

        $this->assertTrue($user->canDo('users.create'));
    }

    function test_if_user_does_not_have_a_permission_slug()
    {
        $user = $this->createDefaultUser();
        $role = $this->createAdminRole();

        $user->attachRole($role);

        $this->assertFalse($user->canDo('users.create'));
    }

    function test_if_can_check_a_user_role()
    {
        $user = $this->createDefaultUser();
        $role = \Yasser\Roles\Models\Role::create([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        $user->attachRole($role);

        $this->assertTrue($user->checkRole('admin'));
    }
}