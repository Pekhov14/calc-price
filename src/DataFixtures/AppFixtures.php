<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $product1 = new Product();
         $product1->setName('Наушники')
                 ->setPrice(100)
         ;

        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Чехол')
                ->setPrice(20)
        ;

        $manager->persist($product2);
        $manager->flush();

        $tax1 = new Country();
        $tax1->setCode('de')
             ->setTax(19)
             ->setName('Германия')
        ;
        $manager->persist($tax1);

        $tax2 = new Country();
        $tax2->setCode('gr')
             ->setTax(24)
             ->setName('греция')
        ;
        $manager->persist($tax2);

        $tax3 = new Country();
        $tax3->setCode('it')
             ->setTax(22)
             ->setName('Италия')
        ;
        $manager->persist($tax3);
        $manager->flush();
    }
}
