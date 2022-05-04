<?php

namespace App\Tests\securityTesting;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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

        $crawler = $client->request('GET', '/product/1');

        $responseCode = $client->getResponse()->getStatusCode();
        $this->assertSame(Response::HTTP_OK, $responseCode);
        $this->assertSelectorTextNotContains('body', 'Edit');
    }
}