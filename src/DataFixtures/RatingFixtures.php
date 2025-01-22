<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Trip;
use App\Entity\User;
use App\Entity\Rating;
use App\DataFixtures\TripFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RatingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $userArray = [];
        for ($i=0; $i < 300; $i++) {
            $userArray[] = $this->getReference('user_' . $i, User::class);
        }
        
        $tripArray = [];
        for ($i=0; $i < 1000; $i++) {
            $tripArray[] = $this->getReference('trip_' . $i, Trip::class);
        }

        for ($i = 0; $i < 500; $i++) {
            $user = $faker->randomElement($userArray);
            $rate = new Rating();
            $rate
                ->setNote($faker->numberBetween(1, 5))
                ->setIpAddress($faker->ipv4)
                ->setEvaluator($user)
                ->setTrip($faker->randomElement($tripArray))
            ;
            $manager->persist($rate);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class, 
            TripFixtures::class
        ];
    }
}
