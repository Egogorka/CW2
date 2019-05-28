<?php

namespace Tests\Unit;

use eduslim\domain\user\User;
use eduslim\interfaces\domain\user\UserInterface;

class HomepageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testInterface()
    {
        $user = new User();
        $this->assertInstanceOf(UserInterface::class, $user);
    }

    /**
     * Test that the index route with optional name argument returns a rendered greeting
     */
    public function testSettersAndGetters()
    {
        $user = new User();
        $id = rand(1, 999999);
        $name = 'username' . rand(1, 999999);
        $passwordHash = md5('password' . rand(1, 999999));
        $user->setId($id);
        $user->setUsername($name);
        $user->setPassHash($passwordHash);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($name, $user->getUsername());
        $this->assertEquals($passwordHash, $user->getPassHash());
    }
}