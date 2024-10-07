<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use App\Entity\Manufacturer\ManufacturerInterface;
use App\Repository\ManufacturerRepositoryInterface;
use Behat\Behat\Context\Context;
use Sylius\Component\Core\Formatter\StringInflector;
use Webmozart\Assert\Assert;

final class ManufacturerContext implements Context
{
    public function __construct(
        private ManufacturerRepositoryInterface $manufacturerRepository,
    ) {
    }

    /**
     * @Transform /^belongs to "([^"]+)"$/
     * @Transform :manufacturer
     */
    public function getManufacturerByName(string $name): ManufacturerInterface
    {
        $code = StringInflector::nameToCode($name);
        $manufacturer = $this->manufacturerRepository->finOneByCode($code);

        Assert::isInstanceOf($manufacturer, ManufacturerInterface::class);

        return $manufacturer;
    }
}
