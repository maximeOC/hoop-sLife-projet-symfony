<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixture extends Fixture
{
    private $count = 1;
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
         $parentCat = $this->createCategory('Vêtements', null, $manager);
         $this->createCategory('shorts', $parentCat, $manager);
         $this->createCategory('pull/hoodies', $parentCat, $manager);
         $this->createCategory('basket', $parentCat, $manager);
         $this->createCategory('casquettes', $parentCat, $manager);

        $parentCat = $this->createCategory('Accesoires', null, $manager);

        $this->createCategory('bracelets', $parentCat, $manager);
        $this->createCategory('funko pop', $parentCat, $manager);
        $this->createCategory('Mini basket', $parentCat, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parentCat = null, ObjectManager $manager){
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parentCat);
        $manager->persist($category);

        $this->addReference('cat-'. $this->count, $category);
        $this->count++;
        return $category;
    }
}
