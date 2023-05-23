<?php

namespace App\DataFixtures;

use App\Entity\Product;

use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<100; $i++)
        {
            $product = new Product();
            $product->setName($faker->words(3, true))
                ->setDescription($faker->paragraphs(4, true))
                ->setPrice($faker->numberBetween(20000, 100000))
                ->setBrand($faker->company())
                ->setColor($faker->colorName())
                ->setTaxes($faker->numberBetween(2000, 10000))
            ;

            $manager->persist($product);
        }
        $manager->flush();
    }
}
