<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Manufacturer\ManufacturerInterface;
use App\Entity\Product\ProductInterface;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;

final class ProductManufacturerContext implements Context
{
    public function __construct(
        private EntityManagerInterface $productManager,
    ) {
    }

    /**
     * @Given /^I assigned (this product) to ("[^"]+" manufacturer)$/
     * @Given /^(it|this product) (belongs to "[^"]+")$/
     * @Given the product :product belongs to manufacturer :manufacturer
     */
    public function itBelongsTo(ProductInterface $product, ManufacturerInterface $manufacturer): void
    {
        $product->setManufacturer($manufacturer);

        $this->productManager->persist($product);
        $this->productManager->flush();
    }
}
