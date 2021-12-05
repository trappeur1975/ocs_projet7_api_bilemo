<?php

namespace App\DataFixtures;

use App\Entity\Compagny;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompagnyFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // we create the compagny 
        for ($nbrCompagny = 1; $nbrCompagny <= 9; $nbrCompagny++) {

            $compagny = new Compagny();
            $compagny->setEmail('compagny' . $nbrCompagny . '@test.com') //compagny1@test.com, compagny2@test.com, ...
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->encoder->encodePassword($compagny, 'compagny' . $nbrCompagny))  //compagny1, compagny2, ...
                ->setName('compagny' . $nbrCompagny)    //compagny1, compagny2, ...
                ->setPhone('02 62 34 20 1' . $nbrCompagny);

            $manager->persist($compagny);

            // we save the reference of the compagny
            $this->addReference('compagny' . $nbrCompagny, $compagny);
        }

        $manager->flush();
    }
}
