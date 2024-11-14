<?php

declare(strict_types=1);

namespace App\Importer\DTO;

interface ManufacturerDTOInterface
{
    public function getCode(): string;

    public function setCode(string $code): void;

    public function getName(): string;

    public function setName(string $name): void;
}
