<?php

declare(strict_types=1);

namespace App\Importer\DTO;

final class ProductDTO
{
    private string $code;

    private bool $enabled;

    private string $mainTaxon;

    private array $taxons = [];

    private array $channels = [];

    private array $translations = [];

    private array $images = [];

    private array $variants = [];

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

    public function getMainTaxon(): string
    {
        return $this->mainTaxon;
    }

    public function setMainTaxon(string $mainTaxon): void
    {
        $this->mainTaxon = $mainTaxon;
    }

    public function getTaxons(): array
    {
        return $this->taxons;
    }

    public function setTaxons(array $taxons): void
    {
        $this->taxons = $taxons;
    }

    public function getChannels(): array
    {
        return $this->channels;
    }

    public function setChannels(array $channels): void
    {
        $this->channels = $channels;
    }

    /** @return ProductTranslationDTO[] */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): void
    {
        $this->translations = $translations;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /** @return ProductVariantDTO[] */
    public function getVariants(): array
    {
        return $this->variants;
    }

    public function setVariants(array $variants): void
    {
        $this->variants = $variants;
    }
}
