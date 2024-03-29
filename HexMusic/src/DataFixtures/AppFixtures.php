<?php

namespace App\DataFixtures;

use App\Factory\BookingFactory;
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

        $student1 = UserFactory::createOne([
            'username' => 'student',
            'password' => 'pass',
            'role' => 'ROLE_STUDENT'
        ]);

        $teacher1 = UserFactory::createOne([
            'username' => 'teacher',
            'password' => 'pass',
            'role' => 'ROLE_TEACHER'
        ]);
        UserFactory::createOne([
            'username' => 'user',
            'password' => 'pass',
            'role' => 'ROLE_USER'
        ]);
        ProductFactory::createOne([
            'name' =>"Ibanez Guitar",
            'type' => "Electric Guitar",
            'price' => 1000,
            'image' => "timGuitar.jpg"
        ]);

        BookingFactory::createOne([

            'title'=>"Music lesson at Tim's",
            'beginAt' => new \DateTime("2022-05-05T02:02:00"),
            'endAt' => new \DateTime("2022-05-05 04:02:00"),
            'teacher' => $teacher1,
            'student' =>$student1
        ]);
    }
}
