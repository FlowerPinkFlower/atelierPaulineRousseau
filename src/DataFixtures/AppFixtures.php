<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR'); //permet de générer des données française

        // POUR LES CATEGORIES
        for ($c=0; $c<2 ; $c++) { 
            $cat = new Category();
            $cat->setName($faker->word());  //Création de faux nom de catégories
            $cat->setDescription($faker->realText($maxNbChars=100, $indexSize=2));  
            $manager->persist($cat); 

            //POUR LES SOUS CATEGORIES
            for ($s=0; $s<3 ; $s++) { 
                $subCate= new SubCategory();
                $subCate->setName($faker->word());
                $subCate->setDescription($faker->realText($maxNbChars=100, $indexSize=2));
                // $subCate->setCategory($cat);
                $manager->persist($subCate);

                
                //POUR LES PRODUITS
                for ($p=0; $p<1 ; $p++) { 
                    $prod=new Product();
                    $prod->setName($faker->word());
                    $prod->setQuantity($faker->randomNumber(2, true));
                    $prod->setunitPrice($faker->randomFloat(2, 1,35)); 
                    $prod->setSubCategory($subCate);
                    $manager->persist($prod);
                }
                
            }
            $manager->flush();
        }
    }
}
