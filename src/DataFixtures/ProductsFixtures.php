<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;


//
//    public function load(ObjectManager $manager): void
//    {
//        $this->createProducts('Memphis Grizzlies Nike City Edition Swingman Jersey 22 - Noir - Ja Morant - Unisexe'
//            , 9999
//            , 20
//            ,"Obtenez une véritable sensation professionnelle avec cet excellent article de reproduction. Fabriqué à partir de matériaux de qualité supérieure et façonné d'après la bande de votre équipe préférée, vous aurez l'air et la sensation de la pièce à"
//            , $manager);
//        $this->createProducts('Memphis Grizzlies Nike City Edition Swingman Jersey 22 - Noir - Ja Morant - Unisexe'
//            , 9999
//            , 20
//            ,"Obtenez une véritable sensation professionnelle avec cet excellent article de reproduction. Fabriqué à partir de matériaux de qualité supérieure et façonné d'après la bande de votre équipe préférée, vous aurez l'air et la sensation de la pièce à"
//            , $manager);
//        $manager->flush();
//    }
//    public function createProducts(string $name, int $price, int $stock, string $description, ObjectManager $manager,   ){
//        $product = new Products();
//        $product
//            ->setName($name)
//            ->setPrice($price)
//            ->setStock($stock)
//            ->setDescription($description)
//            ->setSlug($this->slugger->slug($product->getName())->lower());
//        $manager->persist($product);
//
//            $manager->flush();
//    }
//}

class ProductsFixtures extends Fixture{
    public function __construct(
        private SluggerInterface $slugger
    ){}
     public function load(ObjectManager $manager): void{
        $faker = Faker\Factory::create('fr_FR');

        for ($products = 1; $products<=10; $products++){
            $product = new Products();
            $product
                ->setName($faker->text(50))
                ->setDescription($faker->text(300))
                ->setSlug($this->slugger->slug($product->getName())->lower())
                ->setPrice($faker->numberBetween(2000, 15000))
                ->setStock($faker->numberBetween(0, 20));

            //référence de la categorie
            $category = $this->getReference('cat-'.rand(1, 8));
            $product->setCategories($category);
            $manager->persist($product);
        }
        $manager->flush();
    }
    }


