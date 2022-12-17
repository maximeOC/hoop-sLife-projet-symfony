<?php

namespace App\Entity;

use App\Repository\SizesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizesRepository::class)]
class Sizes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Products::class, inversedBy: 'sizes')]
    private Collection $sizeName;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $name = null;

    public function __construct()
    {
        $this->sizeName = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getSizeName(): Collection
    {
        return $this->sizeName;
    }

    public function addSizeName(Products $sizeName): self
    {
        if (!$this->sizeName->contains($sizeName)) {
            $this->sizeName->add($sizeName);
        }

        return $this;
    }

    public function removeSizeName(Products $sizeName): self
    {
        $this->sizeName->removeElement($sizeName);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }


}
