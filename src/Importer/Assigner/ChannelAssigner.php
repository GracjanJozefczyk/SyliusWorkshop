<?php

declare(strict_types=1);

namespace App\Importer\Assigner;

use App\Importer\DTO\ProductDTO;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class ChannelAssigner
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository
    ) {
    }

    public function assign(ProductDTO $productDTO, ProductInterface $product): void
    {
        foreach ($productDTO->getChannels() as $channelCode) {
            $channel = $this->channelRepository->findOneByCode($channelCode);
            if (!$channel instanceof ChannelInterface) {
                continue;
            }

            $product->addChannel($channel);
        }
    }
}
