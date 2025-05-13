<?php

namespace system;

use App\Entity\User;
use App\Tools\AbstractKernelTestCase;

class UserTest extends AbstractKernelTestCase
{
    public function testUserCreation(): void
    {
        // Create a new user
        $user = new User();
        $user->setUsername('testuser');
        $user->setPassword('testpassword');
        $user->setApiToken('testapitoken');
        
        // Persist the user to the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        // Retrieve the user from the database
        $retrievedUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'testuser']);
        
        // Assert that the user was created correctly
        $this->assertNotNull($retrievedUser);
        $this->assertEquals('testuser', $retrievedUser->getUsername());
        $this->assertEquals('testpassword', $retrievedUser->getPassword());
        $this->assertEquals('testapitoken', $retrievedUser->getApiToken());
        $this->assertContains('ROLE_USER', $retrievedUser->getRoles());
    }
}