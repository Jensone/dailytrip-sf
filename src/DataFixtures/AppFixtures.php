<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // Chargement de Faker
        $categories = [
            'Désert',
            'Montagne',
            'Forêt',
            'Roadtrip',
            'Grotte',
            'Trail',
            'VTT',
            'Littoral',
            'Îles'
        ];
        $categoryArray = []; // Tableau vide
        for ($i=0; $i < count($categories); $i++) { 
            $category = new Category();
            $category
                ->setName($categories[$i])
                ->setImage('https://picsum.photos/300/300?random='.$i)
            ;
            array_push($categoryArray, $category); // Ajout dans le tableau
            $manager->persist($category); // Ajoute à la BDD
        }

        for ($i=0; $i < 1000; $i++) { 
            $trip = new Trip();
            $trip
                ->setRef(uniqid('trip-', true))
                ->setTitle($faker->sentence(3))
                ->setDescription($faker->paragraph(4))
                ->setCover('https://picsum.photos/1280/720?random='.$i)
                ->setEmail($faker->email())
                ->setStatus($faker->boolean(70))
                // Ici on utilise le tableau de categories pour en assigner à l'objet Trip
                ->setCategory($faker->randomElement($categoryArray))
            ;

            $manager->persist($trip);
        }

        $manager->flush(); // Exécute les requêtes SQL générées par Doctrine
    }
}
