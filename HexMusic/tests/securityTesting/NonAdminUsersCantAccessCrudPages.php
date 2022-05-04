<?php

namespace App\Tests\securityTesting;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NonAdminUsersCantAccessCrudPages extends WebTestCase
{
    public function testUserCannotAccessUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $userName = 'user';
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByusername($userName);
        $client->loginUser($user);

        $crawler = $client->request('GET', '/user');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_MOVED_PERMANENTLY, $responseCode);
    }

    public function testStudentCannotAccessUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $userName = 'student';
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByusername($userName);
        $client->loginUser($user);

        $crawler = $client->request('GET', '/user');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_MOVED_PERMANENTLY, $responseCode);
    }

    public function testTeacherCannotAccessUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $userName = 'teacher';
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByusername($userName);
        $client->loginUser($user);

        $crawler = $client->request('GET', '/user');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_MOVED_PERMANENTLY, $responseCode);
    }
}