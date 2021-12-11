<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CustomerFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // we create the compagny 
        for ($nbrCustommer = 1; $nbrCustommer <= 200; $nbrCustommer++) {

            // we retrieve the reference of the compagny
            $compagny = $this->getReference('compagny' . rand(1, 9));

            $customer = new Customer();
            $customer->setFirstname('clientPrenom' . $nbrCustommer) //clientPrenom1, clientPrenom2, ...
                ->setLastName('clientNom' . $nbrCustommer) //clientNom1, clientNom2, ...
                ->setEmail('customer' . $nbrCustommer . '@test.com') //customer1@test.com, customer2@test.com, ...
                ->setPhone('02 62 34 20 ' . rand(10, 80))
                ->setAdress('adresse client' . $nbrCustommer)    //adresse client1, adresse client2, ...
                ->setCompagny($compagny);

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
