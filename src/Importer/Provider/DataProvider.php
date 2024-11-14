<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use App\Importer\DTO\ManufacturerDTO;
use App\Importer\DTO\ManufacturerDTOInterface;
use League\Flysystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

final class DataProvider implements DataProviderInterface
{
    private const FILE_NAME = 'manufacturer_import.csv';

    private const FILE_FORMAT = 'csv';

    public function __construct(
        private Filesystem $filesystem,
        private SerializerInterface $serializer,
    ) {
    }

    /** @return ManufacturerDTOInterface[] */
    public function provide(): array
    {
        $file = $this->filesystem->read(self::FILE_NAME);
        return $this->serializer->deserialize(
            $file,
            ManufacturerDTO::class . '[]',
            self::FILE_FORMAT
        );
    }
}
