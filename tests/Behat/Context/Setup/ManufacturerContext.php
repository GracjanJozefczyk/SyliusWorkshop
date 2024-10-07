<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Manufacturer\ManufacturerInterface;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Resource\Factory\FactoryInterface;

final class ManufacturerContext implements Context
{
    public function __construct(
        private FactoryInterface $manufacturerFactory,
        private EntityManagerInterface $manufacturerManager,
    ) {
    }

    /**
     * @Given the store has :firstManufacturerName manufacturer
     * @Given the store has available manufacturers as :firstManufacturerName
     * @Given the store has available manufacturers as :firstManufacturerName and :secondManufacturerName
     * @Given the store has available manufacturers as :firstManufacturerName and :secondManufacturerName and :thirdManufacturerName
     */
    public function storeHasAvailableManufacturers(...$manufacturers): void
    {
        foreach ($manufacturers as $manufacturerName) {
            $manufacturer = $this->createManufacturer($manufacturerName);
            $this->manufacturerManager->persist($manufacturer);
        }
    }

    private function createManufacturer(string $name): ManufacturerInterface
    {
        /** @var ManufacturerInterface $manufacturer */
        $manufacturer = $this->manufacturerFactory->createNew();
        $manufacturer->setCode(StringInflector::nameToCode($name));
        $manufacturer->setName($name);

        return $manufacturer;
    }
}
