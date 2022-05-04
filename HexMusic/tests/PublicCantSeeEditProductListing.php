<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PublicCantSeeEditProductListing extends WebTestCase
{
    public function testHomePageTitleText(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('nav', 'Catalog');
    }

    public function testUserCanAccessCatalog(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');


        $crawler = $client->request('GET', '/catalog');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_OK, $responseCode);
    }

    public function testUserCanAccessCatalogProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        
        $crawler = $client->request('GET', '/product/1');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_OK, $responseCode);
    }

    public function testUserCantSeeEditOnProduct(): void
    {
        $client = static::createClient();

        //user login
//        $userName = 'user';
//        $userRepository = static::getContainer()->get(UserRepository::class);
//        $user = $userRepository->findOneByusername($userName);
//        $client->loginUser($user);

        $crawler = $client->request('GET', '/product/1');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_OK, $responseCode);
        $this->assertSelectorTextNotContains('body', 'Edit');
    }
}