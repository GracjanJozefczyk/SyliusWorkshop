<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use App\Importer\DTO\ManufacturerDTOInterface;

interface DataProviderInterface
{
    /** @return ManufacturerDTOInterface[] */
    public function provide(): array;
}
