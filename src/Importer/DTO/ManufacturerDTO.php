<?php

declare(strict_types=1);

namespace App\Importer\DTO;

final class ManufacturerDTO implements ManufacturerDTOInterface
{
    private string $code;

    private string $name;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
