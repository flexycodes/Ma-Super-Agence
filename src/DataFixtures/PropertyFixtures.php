<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $property = new Property();

            $property
                ->setTitle($faker->words(3, $asText = true))
                ->setDescription($faker->paragraphs(20, $asText = true))
                ->setShortdescription($faker->sentences(3, $asText = true))
                ->setSurface($faker->numberBetween(10, 500))
                ->setRooms($faker->numberBetween(1, 10))
                ->setBedrooms($faker->numberBetween(1, 10))
                ->setFloor($faker->numberBetween(1, 10))
                ->setPrice($faker->numberBetween(10000, 100000000))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) -1))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setSold(false)
            ;

            $manager->persist($property);
        }

        $manager->flush();
    }
}
