<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use App\Entity\Manufacturer\ManufacturerInterface;

interface ManufacturerProviderInterface
{
    public function provide(string $code): ManufacturerInterface;
}
