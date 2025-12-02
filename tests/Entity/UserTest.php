<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
   public function testEmailGetterAndSetter()
   {
       $user = new User();
       $user->setEmail('john.doe@example.com');

       $this->assertEquals('john.doe@example.com', $user->getEmail());
   }
}