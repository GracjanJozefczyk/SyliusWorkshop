<?php

declare(strict_types=1);

namespace App\Importer\DTO;

final class ProductVariantOptionDTO
{
    private string $optionCode;

    private string $valueCode;

    private array $translations = [];

    public function getOptionCode(): string
    {
        return $this->optionCode;
    }

    public function setOptionCode(string $optionCode): void
    {
        $this->optionCode = $optionCode;
    }

    public function getValueCode(): string
    {
        return $this->valueCode;
    }

    public function setValueCode(string $valueCode): void
    {
        $this->valueCode = $valueCode;
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
