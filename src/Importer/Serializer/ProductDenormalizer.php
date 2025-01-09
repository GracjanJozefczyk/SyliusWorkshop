<?php

declare(strict_types=1);

namespace App\Importer\Serializer;

use App\Importer\DTO\ProductDTO;
use App\Importer\DTO\ProductTranslationDTO;
use App\Importer\DTO\ProductVariantDTO;
use App\Importer\DTO\ProductVariantOptionDTO;
use App\Importer\DTO\ProductVariantPriceDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ProductDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
    ) {

    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ProductDTO
    {
        /** @var ProductDTO $product */
        $product = $this->denormalizer->denormalize(
            $data,
            ProductDTO::class,
            $format,
            $context
        );

        $this->denormalizeTranslations($data, $product);
        $this->denormalizeVariants($data, $product);

        return $product;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === ProductDTO::class;
    }

    private function denormalizeTranslations(array $data, ProductDTO $product): void
    {
        if (isset($data['translations']) && is_array($data['translations'])) {
            $translations = [];
            foreach ($data['translations'] as $locale => $translationData) {
                /** @var ProductTranslationDTO $translation */
                $translation = $this->denormalizer->denormalize(
                    $translationData,
                    ProductTranslationDTO::class,
                );
                $translations[$locale] = $translation;
            }
            $product->setTranslations($translations);
        }
    }

    private function denormalizeVariants(array $data, ProductDTO $product): void
    {
        if (isset($data['variants']) && is_array($data['variants'])) {
            $variants = [];
            foreach ($data['variants'] as $variantData) {
                /** @var ProductVariantDTO $variant */
                $variant = $this->denormalizer->denormalize(
                    $variantData,
                    ProductVariantDTO::class,
                );
                $this->denormalizePricing($variant);
                $this->denormalizeOptions($variant);
                $variants[] = $variant;
            }

            $product->setVariants($variants);
        }
    }

    private function denormalizePricing(ProductVariantDTO $variant): void
    {
        $pricing = [];
        foreach ($variant->getPricing() as $priceData) {
            /** @var ProductVariantPriceDTO $price */
            $price = $this->denormalizer->denormalize(
                $priceData,
                ProductVariantPriceDTO::class,
            );
            $pricing[] = $price;
        }

        $variant->setPricing($pricing);
    }

    private function denormalizeOptions(ProductVariantDTO $variant): void
    {
        $options = [];
        foreach ($variant->getOptions() as $optionData) {
            /** @var ProductVariantOptionDTO $option */
            $option = $this->denormalizer->denormalize(
                $optionData,
                ProductVariantOptionDTO::class,
            );
            $options[] = $option;
        }

        $variant->setOptions($options);
    }
}
