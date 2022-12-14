<?php

namespace App\Entity;

use App\Entity\Trait\Slug;
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    use Slug;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: 'integer')]
    private ?int $catOrder ;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Products::class)]
    private Collection $products;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?MainCategories $mainCategories = null;

    public function __construct()
    {
//        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCatOrder(): ?int{
        return $this->catOrder;
    }

    public function setCatOrder(int $catOrder): self{
       $this->catOrder = $catOrder;
       return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategories($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategories() === $this) {
                $product->setCategories(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getMainCategories(): ?MainCategories
    {
        return $this->mainCategories;
    }

    public function setMainCategories(?MainCategories $mainCategories): self
    {
        $this->mainCategories = $mainCategories;
        return $this;
    }


}
