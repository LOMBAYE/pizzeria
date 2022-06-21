<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Client;
use App\Entity\Livreur;
use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // private $passwordEncoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    { for ($i=0; $i <6 ; $i++) { 
        $faker= Factory::create();

        $product = new Gestionnaire();
        $prod = new Client();
        $pr = new Livreur();
        // $hash=
        $product->setNomComplet($faker->name());
        $product->setEmail($faker->email());
        $product->setPassword($this->passwordEncoder->hashPassword($product,"password"));
        $manager->persist($product);

        $prod->setNomComplet($faker->name());
        $prod->setEmail($faker->email());
        $prod->setPassword($this->passwordEncoder->hashPassword($product,"password"));
        $manager->persist($prod);

        $pr->setNomComplet($faker->name());
        $pr->setEmail($faker->email());
        $pr->setPassword($this->passwordEncoder->hashPassword($product,"password"));
        $pr->setEtat(1);
        $pr->setMatricule("MAT".$i);

        $manager->persist($pr);

        $manager->flush();
    }
}
}
