<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Resource\Factory\FactoryInterface;

final class ChannelPricingProvider
{
    public function __construct(
        private FactoryInterface $channelPricingFactory
    ) {
    }

    public function provide(ProductVariantInterface $productVariant, string $channelCode): ChannelPricingInterface
    {
        foreach ($productVariant->getChannelPricings() as $channelPricing) {
            if ($channelPricing->getChannelCode() === $channelCode) {
                return $channelPricing;
            }
        }

        /** @var ChannelPricingInterface $channelPricing */
        $channelPricing = $this->channelPricingFactory->createNew();
        $channelPricing->setChannelCode($channelCode);
        $channelPricing->setProductVariant($productVariant);

        return $channelPricing;
    }
}
