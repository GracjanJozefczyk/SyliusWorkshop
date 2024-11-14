<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use App\Entity\Manufacturer\ManufacturerInterface;
use App\Repository\ManufacturerRepositoryInterface;
use Sylius\Resource\Factory\FactoryInterface;

final class ManufacturerProvider implements ManufacturerProviderInterface
{
    public function __construct(
        private ManufacturerRepositoryInterface $manufacturerRepository,
        private FactoryInterface $manufacturerFactory,
    ) {
    }

    public function provide(string $code): ManufacturerInterface
    {
        $manufacturer = $this->manufacturerRepository->finOneByCode($code);
        if ($manufacturer instanceof ManufacturerInterface) {
            return $manufacturer;
        }

        /** @var ManufacturerInterface $manufacturer */
        $manufacturer = $this->manufacturerFactory->createNew();
        $manufacturer->setCode($code);

        return $manufacturer;
    }
}
