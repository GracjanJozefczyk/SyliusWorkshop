<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\Manufacturer\ManufacturerInterface;
use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;

interface ProductInterface extends BaseProductInterface
{
    public function getManufacturer(): ?ManufacturerInterface;

    public function setManufacturer(?ManufacturerInterface $manufacturer): void;
}
