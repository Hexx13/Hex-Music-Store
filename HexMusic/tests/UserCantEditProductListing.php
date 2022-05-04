<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserCantEditProductListing extends WebTestCase
{
    public function testHomePageTitleText(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('a', 'Catalog');
    }
//    public function testUserCannotAccessAdminPanel(): void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/');
//
//        $userName = 'user';
//        $userRepository = static::getContainer()->get(UserRepository::class);
//        $user = $userRepository->findOneByusername($userName);
//        $client->loginUser($user);
//
//        $crawler = $client->request('GET', '/adminpanel');
//
//        $responseCode = $client->getResponse()->getStatusCode();
//        $this->assertSame(Response::HTTP_FORBIDDEN, $responseCode);
//    }
}