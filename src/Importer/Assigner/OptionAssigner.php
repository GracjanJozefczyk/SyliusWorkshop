<?php

declare(strict_types=1);

namespace App\Importer\Assigner;

use App\Importer\DTO\ProductVariantDTO;
use App\Importer\Provider\ProductOptionValueProvider;
use App\Importer\Provider\ResourceProvider;
use App\Importer\Provider\TranslationProvider;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueTranslation;
use Sylius\Component\Product\Model\ProductOptionValueTranslationInterface;

final class OptionAssigner
{
    public function __construct(
        private ResourceProvider $productOptionProvider,
        private ProductOptionValueProvider $productOptionValueProvider,
        private TranslationProvider $translationProvider
    ) {
    }

    public function assign(ProductVariantDTO $productVariantDTO, ProductVariantInterface $productVariant, ProductInterface $product): void
    {
        foreach ($productVariantDTO->getOptions() as $option) {
            /** @var ProductOptionInterface $productOption */
            $productOption = $this->productOptionProvider->provide($option->getOptionCode(), false);
            $productOptionValue = $this->productOptionValueProvider->provide($productOption, $option->getValueCode());

            foreach ($option->getTranslations() as $localeCode => $translation) {
                /** @var ProductOptionValueTranslationInterface $productOptionValueTranslation */
                $productOptionValueTranslation = $this->translationProvider->provide(
                    $productOptionValue,
                    ProductOptionValueTranslation::class,
                    $localeCode
                );
                $productOptionValueTranslation->setValue($translation);
                $productOptionValue->addTranslation($productOptionValueTranslation);
            }

            $productVariant->addOptionValue($productOptionValue);
            $product->addOption($productOption);
        }
    }
}
