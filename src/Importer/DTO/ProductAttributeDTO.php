<?php

declare(strict_types=1);

namespace App\Importer\DTO;

final class ProductAttributeDTO
{
    private string $code;

    private string $type;

    private array $choices = [];

    private array $translations = [];

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): void
    {
        $this->translations = $translations;
    }
}
