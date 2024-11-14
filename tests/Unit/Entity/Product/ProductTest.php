<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Product;

use App\Entity\Manufacturer\ManufacturerInterface;
use App\Entity\Product\Product;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function test_get_manufacturer(): void
    {
        $product = new Product();
        $manufacturer = self::createMock(ManufacturerInterface::class);
        $product->setManufacturer($manufacturer);
        self::assertSame($manufacturer, $product->getManufacturer());
    }
}
