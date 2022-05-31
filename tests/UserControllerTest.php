<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testVisitingWhileLoggedIn(): void
    {
        $client = static::createClient();

        $userRepository = static::$kernel->getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findUserByID(1);

        $client->loginUser($testUser);


        $client->request('GET', '/user');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello,user 1');
    }
}
