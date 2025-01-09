<?php

declare(strict_types=1);

namespace App\Importer\Assigner;

use App\Importer\DTO\ProductVariantDTO;
use App\Importer\Provider\ChannelPricingProvider;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class PricingAssigner
{
    public function __construct(
        private ChannelPricingProvider $channelPricingProvider
    ) {
    }

    public function assign(ProductVariantDTO $productVariantDTO, ProductVariantInterface $productVariant): void
    {
        foreach ($productVariantDTO->getPricing() as $price) {
            $channelPricing = $this->channelPricingProvider->provide($productVariant, $price->getChannel());
            $channelPricing->setPrice($price->getPrice());
            $channelPricing->setOriginalPrice($price->getOriginalPrice());
            $channelPricing->setMinimumPrice($price->getMinimumPrice());

            $productVariant->addChannelPricing($channelPricing);
        }
    }
}
