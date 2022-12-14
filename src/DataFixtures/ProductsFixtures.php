<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{
    public function __construct(
        private SluggerInterface $slugger
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
//        $faker = Faker\Factory::create('fr_FR');
//
//        for ($products = 1; $products<=20; $products++){
//            $product = new Products();
//            $product
//                ->setName($faker->text(50))
//                ->setDescription($faker->text(300))
//                ->setSlug($this->slugger->slug($product->getName())->lower())
//                ->setPrice($faker->numberBetween(2000, 30000))
//                ->setStock($faker->numberBetween(0, 20));
//
//            $category = $this->getReference('cat-'.rand(1, 8));
//            $product->setCategories($category);
//            $this->setReference('prod-'.$products, $product);
//
//            $manager->persist($product);
//        }
//        $manager->flush();
    }
}
