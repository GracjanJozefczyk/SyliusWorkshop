<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\Manufacturer\ManufacturerInterface;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    private ?ManufacturerInterface $manufacturer = null;

    public function getManufacturer(): ?ManufacturerInterface
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?ManufacturerInterface $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }
}
