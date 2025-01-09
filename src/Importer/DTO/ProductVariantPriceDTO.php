<?php

declare(strict_types=1);

namespace App\Importer\DTO;

final class ProductVariantPriceDTO
{
    private string $channel;

    private int $price;

    private int $originalPrice;

    private int $minimumPrice;

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getOriginalPrice(): int
    {
        return $this->originalPrice;
    }

    public function setOriginalPrice(int $originalPrice): void
    {
        $this->originalPrice = $originalPrice;
    }

    public function getMinimumPrice(): int
    {
        return $this->minimumPrice;
    }

    public function setMinimumPrice(int $minimumPrice): void
    {
        $this->minimumPrice = $minimumPrice;
    }

}
