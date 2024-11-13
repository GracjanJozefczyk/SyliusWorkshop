<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Manufacturer;

use App\Entity\Manufacturer\Manufacturer;
use App\Entity\Product\ProductInterface;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

final class ManufacturerTest extends TestCase
{
    public function test_get_id(): void
    {
        $manufacturer = new Manufacturer();
        self::assertNull($manufacturer->getId());
    }

    public function test_get_code(): void
    {
        $manufacturer = new Manufacturer();
        self::assertNull($manufacturer->getCode());
    }

    public function test_set_code(): void
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setCode('manufacturer_code');
        self::assertSame('manufacturer_code', $manufacturer->getCode());
    }

    public function test_get_name(): void
    {
        $manufacturer = new Manufacturer();
        self::assertNull($manufacturer->getName());
    }

    public function test_set_name(): void
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setName('manufacturer_name');
        self::assertSame('manufacturer_name', $manufacturer->getName());
    }

    public function test_get_products(): void
    {
        $manufacturer = new Manufacturer();
        self::assertInstanceOf(Collection::class, $manufacturer->getProducts());
    }

    public function test_add_product(): void
    {
        $manufacturer = new Manufacturer();
        $product = self::createMock(ProductInterface::class);
        $manufacturer->addProduct($product);
        self::assertCount(1, $manufacturer->getProducts());
    }

    public function test_it_removes_product(): void
    {
        $manufacturer = new Manufacturer();
        $product = self::createMock(ProductInterface::class);
        $manufacturer->addProduct($product);
        self::assertCount(1, $manufacturer->getProducts());
        $manufacturer->removeProduct($product);
        self::assertCount(0, $manufacturer->getProducts());
    }

    public function test_it_has_product(): void
    {
        $manufacturer = new Manufacturer();
        $product = self::createMock(ProductInterface::class);
        $manufacturer->addProduct($product);
        self::assertTrue($manufacturer->hasProduct($product));
    }
}
