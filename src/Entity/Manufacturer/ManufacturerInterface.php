<?php

declare(strict_types=1);

namespace App\Entity\Manufacturer;

use App\Entity\Product\ProductInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface ManufacturerInterface extends ResourceInterface, CodeAwareInterface, TimestampableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getProducts(): Collection;

    public function addProduct(ProductInterface $product): void;

    public function removeProduct(ProductInterface $product): void;

    public function hasProduct(ProductInterface $product): bool;
}
