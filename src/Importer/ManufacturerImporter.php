<?php

declare(strict_types=1);

namespace App\Importer;

use App\Importer\Provider\DataProviderInterface;
use App\Importer\Provider\ManufacturerProviderInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ManufacturerImporter implements ManufacturerImporterInterface
{
    public function __construct(
        private DataProviderInterface $dataProvider,
        private ManufacturerProviderInterface $manufacturerProvider,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function import(): void
    {
        $rows = $this->dataProvider->provide();

        foreach ($rows as $row) {
            $manufacturer = $this->manufacturerProvider->provide($row->getCode());
            $manufacturer->setName($row->getName());

            $this->entityManager->persist($manufacturer);
        }

        $this->entityManager->flush();
    }
}
