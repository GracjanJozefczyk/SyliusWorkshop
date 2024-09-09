<?php

declare(strict_types=1);

namespace App\Entity\Manufacturer;

use App\Entity\Product\ProductInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Resource\Model\TimestampableTrait;

class Manufacturer implements ManufacturerInterface
{
    use TimestampableTrait;

    private ?int $id = null;

    private ?string $code = null;

    private ?string $name = null;

    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setManufacturer($this);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->setManufacturer(null);
        }
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }
}
