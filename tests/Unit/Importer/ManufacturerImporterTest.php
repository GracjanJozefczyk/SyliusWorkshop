<?php

declare(strict_types=1);

namespace App\Tests\Unit\Importer;

use App\Entity\Manufacturer\ManufacturerInterface;
use App\Importer\DTO\ManufacturerDTOInterface;
use App\Importer\ManufacturerImporter;
use App\Importer\Provider\DataProviderInterface;
use App\Importer\Provider\ManufacturerProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class ManufacturerImporterTest extends TestCase
{
    public function test_it_imports(): void
    {
        $manufacturer = self::createMock(ManufacturerInterface::class);
        $manufacturer
            ->expects(self::once())
            ->method('setName')
            ->with('name');

        $dto = self::createMock(ManufacturerDTOInterface::class);
        $dto
            ->expects(self::once())
            ->method('getCode')
            ->willReturn('code');
        $dto
            ->expects(self::once())
            ->method('getName')
            ->willReturn('name');

        $dataProvider = self::createMock(DataProviderInterface::class);
        $dataProvider
            ->expects(self::once())
            ->method('provide')
            ->willReturn([$dto]);

        $manufacturerProvider = self::createMock(ManufacturerProviderInterface::class);
        $manufacturerProvider
            ->expects(self::once())
            ->method('provide')
            ->with('code')
            ->willReturn($manufacturer);

        $entityManager = self::createMock(EntityManagerInterface::class);
        $entityManager
            ->expects(self::once())
            ->method('persist')
            ->with($manufacturer);
        $entityManager
            ->expects(self::once())
            ->method('flush');

        $importer = new ManufacturerImporter(
            $dataProvider,
            $manufacturerProvider,
            $entityManager
        );

        $importer->import();
    }
}
