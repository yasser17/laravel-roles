<?php

class UserClassTest extends TestCase
{
    function test_can_attach_a_role_to_a_user()
    {
        $user = $this->createDefaultUser();
        $role = $this->createAdminRole();

        $user->attachRole($role);

        $this->assertTrue($user->roles()->get()->contains($role));
    }
}