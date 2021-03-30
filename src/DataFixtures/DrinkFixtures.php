<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Drink;

class DrinkFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i <= 10 ; $i++){ 
            $drink = new Drink();
            $drink->setName("Vin rouge n°$i")
                  ->setImages("http://placehold.it/350x150")
                  ->setRegion("Région $i")
                  ->setDescription("Superbe vin rouge n°$i sdsfdezefzdfz")
                  ->setVolume(0.75)
                  ->setPrice($i * 1.54)
                  ->setType("red_wine");
            
            $manager->persist($drink);      
        }

        $manager->flush();

        for($i=1; $i <= 10 ; $i++){ 
            $drink = new Drink();
            $drink->setName("Vin blanc n°$i")
                  ->setImages("http://placehold.it/350x150")
                  ->setRegion("Région $i")
                  ->setDescription("Superbe vin blanc n°$i sdsfdezefzdfz")
                  ->setVolume(0.75)
                  ->setPrice($i * 1.54)
                  ->setType("white_wine");
            
            $manager->persist($drink);      
        }

        $manager->flush();

        for($i=1; $i <= 10 ; $i++){ 
            $drink = new Drink();
            $drink->setName("Vin rosé n°$i")
                  ->setImages("http://placehold.it/350x150")
                  ->setRegion("Région $i")
                  ->setDescription("Superbe vin rosé n°$i sdsfdezefzdfz")
                  ->setVolume(0.75)
                  ->setPrice($i * 1.54)
                  ->setType("rose_wine");
            
            $manager->persist($drink);      
        }

        $manager->flush();

        for($i=1; $i <= 10 ; $i++){ 
            $drink = new Drink();
            $drink->setName("Champagne n°$i")
                  ->setImages("http://placehold.it/350x150")
                  ->setRegion("Région $i")
                  ->setDescription("Superbe champagne n°$i sdsfdezefzdfz")
                  ->setVolume(0.75)
                  ->setPrice($i * 1.54)
                  ->setType("champagne");
            
            $manager->persist($drink);      
        }

        $manager->flush();
    }
}
