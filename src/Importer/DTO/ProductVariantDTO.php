<?php

declare(strict_types=1);

namespace App\Importer\DTO;

final class ProductVariantDTO
{
    private string $code;

    private bool $enabled;

    private array $pricing = [];

    private array $options = [];

    private int $stock;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /** @return ProductVariantPriceDTO[] */
    public function getPricing(): array
    {
        return $this->pricing;
    }

    public function setPricing(array $pricing): void
    {
        $this->pricing = $pricing;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /** @return ProductVariantOptionDTO[] */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
