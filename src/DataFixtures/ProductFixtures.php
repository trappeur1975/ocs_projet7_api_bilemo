<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $tabBrand = ['samsung', 'redmi', 'xiaomi', 'iphone', 'huawei', 'honor', 'realme', 'oppo', 'wiko', 'sony'];

        // we create the prduct 
        for ($nbrProduct = 1; $nbrProduct <= 200; $nbrProduct++) {

            $product = new Product();
            $product->setModel('model' . $nbrProduct)
                ->setBrand($tabBrand[rand(1, 9)])
                ->setPrice(rand(50, 400))
                ->setStock(rand(1, 40))
                ->setDescription('descrition' . $nbrProduct . ' Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis molestias quis laudantium, qui facilis asperiores minus ducimus sint consequuntur ipsum illum nihil iusto, itaque totam dignissimos voluptatem voluptas quisquam sunt.');

            $manager->persist($product);
        }

        $manager->flush();
    }
}
