<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++)
        {
            $client = new Client();
            $client->setName($faker->words(3, true))
                ->setEmail($faker->email)
                ->setPassword($this->passwordHasher->hashPassword($client, 'password'))
            ;

            $manager->persist($client);
            for ($j=0; $j<50; $j++)
            {
                $user = new User();
                $user->setFirstname($faker->firstName)
                    ->setLastname($faker->lastName)
                    ->setEmail($faker->email)
                    ->setClient($client)
                ;

                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
