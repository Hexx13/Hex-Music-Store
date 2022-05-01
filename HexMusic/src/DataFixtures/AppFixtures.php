<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Factory\UserFactory;
use App\Factory\MakeFactory;
use App\Factory\PhoneFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'username' => 'admin',
            'password' => 'pass',
            'role' => 'ROLE_ADMIN'
        ]);

        UserFactory::createOne([
            'username' => 'teacher',
            'password' => 'pass',
            'role' => 'ROLE_TEACHER'
        ]);

        ProductFactory::createOne([
            'name' =>"Ibanez Guitar",
            'type' => "Electric Guitar",
            'price' => 1000
        ]);
    }
}
