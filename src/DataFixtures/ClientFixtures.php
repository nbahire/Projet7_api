<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures  extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $user = new Client();
        $user->setName('admin');

        $user->setEmail('mail@mail.com');
        $manager->persist($user);
        $manager->flush();

        $manager->flush();
    }
}
