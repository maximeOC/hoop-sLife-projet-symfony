<?php

namespace App\Entity;

use App\Repository\DiscountVoucherTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountVoucherTypesRepository::class)]
class DiscountVoucherTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'discountVoucher_types', targetEntity: DiscountVoucher::class, orphanRemoval: true)]
    private Collection $discountVouchers;

    public function __construct()
    {
        $this->discountVouchers = new ArrayCollection();
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

    /**
     * @return Collection<int, DiscountVoucher>
     */
    public function getDiscountVouchers(): Collection
    {
        return $this->discountVouchers;
    }

    public function addDiscountVoucher(DiscountVoucher $discountVoucher): self
    {
        if (!$this->discountVouchers->contains($discountVoucher)) {
            $this->discountVouchers->add($discountVoucher);
            $discountVoucher->setDiscountVoucherTypes($this);
        }

        return $this;
    }

    public function removeDiscountVoucher(DiscountVoucher $discountVoucher): self
    {
        if ($this->discountVouchers->removeElement($discountVoucher)) {
            // set the owning side to null (unless already changed)
            if ($discountVoucher->getDiscountVoucherTypes() === $this) {
                $discountVoucher->setDiscountVoucherTypes(null);
            }
        }

        return $this;
    }
}
