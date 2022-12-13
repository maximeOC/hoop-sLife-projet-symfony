<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixture extends Fixture
{
    private $count = 1;
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
         $parentCat = $this->createCategory('Vêtements', null, $manager, 1);
         $this->createCategory('shorts', $parentCat, $manager, 2);
         $this->createCategory('Maillots', $parentCat, $manager, 3);
         $this->createCategory('pull/hoodies', $parentCat, $manager, 4);
         $this->createCategory('basket', $parentCat, $manager, 5);
         $this->createCategory('casquettes', $parentCat, $manager, 6);

        $parentCat = $this->createCategory('Accessoires', null, $manager, 7);

        $this->createCategory('bracelets', $parentCat, $manager, 8);
        $this->createCategory('funko pop', $parentCat, $manager, 9);
        $this->createCategory('Mini basket', $parentCat, $manager, 10);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parentCat = null, ObjectManager $manager, int $catOrder){
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parentCat);
        $category->setCatOrder($catOrder);
        $manager->persist($category);

        $this->addReference('cat-'. $this->count, $category);
        $this->count++;
        return $category;
    }
}
