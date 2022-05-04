<?php

namespace App\Tests\formFillingUsecases;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserCreateProductListing extends WebTestCase
{

    public function testRoleAdminCanAddModule(): void
    {
        // Arrange - create client
        $client = static::createClient();
        $client->followRedirects();

        // Arrange - get repository references
        $productRepository = static::getContainer()->get(ProductRepository::class);
        $userRepository = static::getContainer()->get(UserRepository::class);
        //$lecturerRepository = static::getContainer()->get(LecturerRepository::class);

        // Arrange - get user - from fixtures
        $username = 'user';
        $user = $userRepository->findOneByUsername($username);

        // Arrange - request parameters
        $httpMethod = 'GET';
        $url = '/product/new';

        // Arrange - count number products BEFORE adding
        $products = $productRepository->findAll();
        $numberOfProductsBeforeOneCreated = count($products);
        $expectedNumberOfProductsAfterOneCreated = $numberOfProductsBeforeOneCreated + 1;

        // Act - login as ADMIN user
        $client->loginUser($user);

        // Act - fill in form to create new module
        $submitButtonName = 'Save';
        $client->submit($client->request($httpMethod, $url)->selectButton($submitButtonName)->form([
            'product2[name]'  => 'TestProduct',
            'product2[price]'  => '10',
            'product2[type]'  => "The product of automated testing",

        ]));

        // Act - get array of products AFTER adding
        $products = $productRepository->findAll();

        // Assert
        $this->assertCount($expectedNumberOfProductsAfterOneCreated, $products);
    }
}