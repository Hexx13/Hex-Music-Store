<?php

namespace App\Tests\securityTesting;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserCantAccessAdminpanel extends WebTestCase
{
    public function testHomePageTitleText(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to Hex Music');
    }
    public function testUserCannotSeeAdminPanel(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('a', 'Admin Panel');
    }
    public function testUserCannotAccessAdminPanel(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $userName = 'user';
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByusername($userName);

        $client->loginUser($user);

        $crawler = $client->request('GET', '/adminpanel');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_FORBIDDEN, $responseCode);
    }
}