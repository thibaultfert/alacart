<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\ProductComment;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //instantiation d'un objet faker dont les données issues seront de type FR 
        $faker = \Faker\Factory::create('fr_FR');

        for ($k=0; $k <= 6; $k++) { 

            // On créer entre 4 et 6 produits pour chaque catégories de vin
            for($i=1; $i <= mt_rand(4, 6) ; $i++){ 
                $product = new Product();

                // On forme un ensemble de parapgraphe grace a faker. 
                // Attention, on utilise join car paragraphs() retourne un tab
                
                $description = join($faker->paragraphs(2), '</br>');

                $product->setName($faker->sentence(4 , false))
                    ->setImages($faker->imageUrl())
                    ->setRegion($faker->word())
                    ->setDescription($description)
                    ->setVolume($faker->randomFloat(2, 0, 5))
                    ->setWeight($faker->randomFloat(2, 0, 5))
                    ->setPrice($faker->randomFloat(2, 27, 180));
                
                if ($k == 0){
                    $product->setType("red_wine");
                }  
                if ($k == 1){
                    $product->setType("white_wine");
                } 
                if ($k == 2){
                    $product->setType("rose_wine");
                } 
                if ($k == 3){
                    $product->setType("champagne");
                } 
                if ($k == 4){
                    $product->setType("foie_gras");
                } 
                if ($k == 5){
                    $product->setType("ham");
                } 
                if ($k == 6){
                    $product->setType("oil");
                }   
                           
                $manager->persist($product);
                
                // On donne des commentaires au produit
                for ($j=1; $j < mt_rand(4, 10) ; $j++) { 

                    $content = join($faker->paragraphs(2), '</br>');

                    $comment = new ProductComment();
                    $comment->setAuthor($faker->name())
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                            ->setProduct($product);
                            
                    $manager->persist($comment);        
                }
            }
        }
            
        $manager->flush();
    }
}
