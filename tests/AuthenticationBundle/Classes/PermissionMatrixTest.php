<?php

namespace Tests\AuthenticationBundle\Classes;

use Ilios\AuthenticationBundle\Classes\PermissionMatrix;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class PermissionMatrixTest
 * @package Tests\AuthenticationBundle\Classes
 */
class PermissionMatrixTest extends TestCase
{
    /**
     * @var PermissionMatrix
     */
    protected $permissionMatrix;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->permissionMatrix = new PermissionMatrix();
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        unset($this->permissionMatrix);
    }

    /**
     * @covers PermissionMatrix::setPermission
     * @covers PermissionMatrix::hasPermission
     */
    public function testHasPermission()
    {
        $schoolId = 1;
        $capability = 'foo';
        $role1 = 'lorem';
        $role2 = 'ipsum';
        $role3 = 'dolor';

        $this->assertFalse($this->permissionMatrix->hasPermission($schoolId, $capability, [$role1]));
        $this->assertFalse($this->permissionMatrix->hasPermission($schoolId, $capability, [$role2]));
        $this->assertFalse($this->permissionMatrix->hasPermission($schoolId, $capability, [$role3]));


        $this->permissionMatrix->setPermission($schoolId, $capability, [$role1, $role2]);

        $this->assertTrue($this->permissionMatrix->hasPermission($schoolId, $capability, [$role1]));
        $this->assertTrue($this->permissionMatrix->hasPermission($schoolId, $capability, [$role2]));
        $this->assertTrue($this->permissionMatrix->hasPermission($schoolId, $capability, [$role1, $role2]));
        $this->assertTrue($this->permissionMatrix->hasPermission($schoolId, $capability, [$role1, $role2, $role3]));
        $this->assertTrue($this->permissionMatrix->hasPermission($schoolId, $capability, [$role1, $role3]));
        $this->assertFalse($this->permissionMatrix->hasPermission($schoolId, $capability, [$role3]));
    }
}