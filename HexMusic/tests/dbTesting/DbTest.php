<?php

namespace App\Tests\dbTesting;

use App\Repository\BookingRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DbTest extends WebTestCase
{
    public function testNumberOfProductsMatchFixtures(): void
    {
        $client = static::createClient();
        $productRepository = static::getContainer()->get(ProductRepository::class);
        $expectedNumberOfEntities = 1;

        $productEntities = $productRepository->findAll();

        $this->assertCount($expectedNumberOfEntities, $productEntities);
    }
    public function testNumberOfUsersMatchFixtures(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $expectedNumberOfEntities = 4;

        $userEntities = $userRepository->findAll();

        $this->assertCount($expectedNumberOfEntities, $userEntities);
    }
    public function testNumberOfBookingMatchFixtures(): void
    {
        $client = static::createClient();
        $bookingRepository = static::getContainer()->get(BookingRepository::class);
        $expectedNumberOfEntities = 1;

        $bookingEntities = $bookingRepository->findAll();

        $this->assertCount($expectedNumberOfEntities, $bookingEntities);
    }
    
}