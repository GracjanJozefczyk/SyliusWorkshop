<?php

declare(strict_types=1);

namespace App\Importer;

interface ManufacturerImporterInterface
{
    public function import(): void;
}
