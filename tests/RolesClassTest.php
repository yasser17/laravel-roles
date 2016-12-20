<?php

use Yasser\Roles\Models\Permission;
use Yasser\Roles\Models\Role;
use Mockery as m;

class RolesClassTest extends PHPUnit_Framework_TestCase
{
    protected $nullFilterTest;
    protected $abortFilterTest;
    protected $customResponseFilterTest;
    protected $expectedResponse;

    public function setUp()
    {
        $this->nullFilterTest = function($filterClosure) {
            if (!($filterClosure instanceof Closure)) {
                return false;
            }
            $this->assertNull($filterClosure());
            return true;
        };
        $this->abortFilterTest = function($filterClosure) {
            if (!($filterClosure instanceof Closure)) {
                return false;
            }
            try {
                $filterClosure();
            } catch (Exception $e) {
                $this->assertSame('abort', $e->getMessage());
                return true;
            }
            // If we've made it this far, no exception was thrown and something went wrong
            return false;
        };
        $this->customResponseFilterTest = function($filterClosure) {
            if (!($filterClosure instanceof Closure)) {
                return false;
            }
            $result = $filterClosure();
            $this->assertSame($this->expectedResponse, $result);
            return true;
        };
    }
    public function tearDown()
    {
        m::close();
    }

    function test_can_attach_a_permission_to_role()
    {
        $role = new Role();
        $permission = new Permission();

        $role->attachPermission($permission);

        $this->assertTrue($role->permissions()->get()->contains($permission));
    }
}