<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Professeur;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $professeur = new Professeur();
            $professeur->setName('Nom' . $i)
                ->setSurname('Prenom' . $i)
                ->setPhone('06' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT))
                ->setMail('prof' . $i . '@example.com');
            $manager->persist($professeur);
        }


        $manager->flush();
    }
}
