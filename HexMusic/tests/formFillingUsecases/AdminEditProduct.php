<?php

namespace App\Tests\formFillingUsecases;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AdminEditProduct extends WebTestCase
{

    public function testRoleAdminCanAddModule(): void
    {
        // Arrange - create client
        $client = static::createClient();
        $client->followRedirects();

        // Arrange - get repository references
        $productRepository = static::getContainer()->get(ProductRepository::class);
        $userRepository = static::getContainer()->get(UserRepository::class);


        // Arrange - get user - from fixtures
        $username = 'admin';
        $user = $userRepository->findOneByUsername($username);


        $originalObject = $productRepository->findOneByid(1);



        // Arrange - request parameters
        $httpMethod = 'GET';
        $url = '/product/1/edit';


        // Act - login as ADMIN user
        $client->loginUser($user);

        // Act - fill in form to create new module
        $submitButtonName = 'Update';
        $client->submit($client->request($httpMethod, $url)->selectButton($submitButtonName)->form([
            'product2[name]'  => "Test Guitar"
        ]));

        $changedProduct = $productRepository->findOneByid(1);

        // Assert
        $this->assertNotSame($changedProduct, $originalObject);
    }
}