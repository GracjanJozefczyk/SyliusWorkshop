<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;
use Sylius\Resource\Factory\FactoryInterface;

final class ProductOptionValueProvider
{
    public function __construct(
        private FactoryInterface $productOptionValueFactory
    ) {
    }

    public function provide(ProductOptionInterface $productOption, string $optionValueCode): ProductOptionValueInterface
    {
        foreach ($productOption->getValues() as $productOptionValue) {
            if ($productOptionValue->getCode() === $optionValueCode) {
                return $productOptionValue;
            }
        }

        /** @var ProductOptionValueInterface $productOptionValue */
        $productOptionValue = $this->productOptionValueFactory->createNew();
        $productOptionValue->setCode($optionValueCode);
        $productOption->addValue($productOptionValue);

        return $productOptionValue;
    }
}
