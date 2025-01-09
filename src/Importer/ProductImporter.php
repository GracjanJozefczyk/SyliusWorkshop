<?php

declare(strict_types=1);

namespace App\Importer;

use App\Importer\Assigner\ChannelAssigner;
use App\Importer\Assigner\ImageAssigner;
use App\Importer\Assigner\OptionAssigner;
use App\Importer\Assigner\PricingAssigner;
use App\Importer\Assigner\TaxonAssigner;
use App\Importer\DTO\ProductDTO;
use App\Importer\Provider\ResourceProvider;
use App\Importer\Provider\TranslationProvider;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslation;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductImporter
{
    private const FILE_NAME = 'product_import.json';

    private const FILE_FORMAT = 'json';

    public function __construct(
        private Filesystem $filesystem,
        private SerializerInterface $serializer,
        private ResourceProvider $productProvider,
        private TranslationProvider $translationProvider,
        private ResourceProvider $productVariantProvider,
        private EntityManagerInterface $productManager,
        private TaxonAssigner $taxonAssigner,
        private ChannelAssigner $channelAssigner,
        private ImageAssigner $imageAssigner,
        private PricingAssigner $pricingAssigner,
        private OptionAssigner $optionAssigner,
    ) {
    }

    public function import(): int
    {
        $file = $this->filesystem->read(self::FILE_NAME);
        $rows = $this->serializer->deserialize(
            $file,
            ProductDTO::class . '[]',
            self::FILE_FORMAT
        );

        /** @var ProductDTO $row */
        foreach ($rows as $row) {
            /** @var ProductInterface $product */
            $product = $this->productProvider->provide($row->getCode());
            $product->setEnabled($row->isEnabled());

            foreach ($row->getTranslations() as $translation) {
                /** @var ProductTranslationInterface $productTranslation */
                $productTranslation = $this->translationProvider->provide(
                    $product,
                    ProductTranslation::class,
                    $translation->getLocale()
                );

                $productTranslation->setName($translation->getName());
                $productTranslation->setSlug($translation->getSlug());
                $productTranslation->setDescription($translation->getDescription());
                $productTranslation->setShortDescription($translation->getShortDescription());
                $product->addTranslation($productTranslation);
            }

            foreach ($row->getVariants() as $variant) {
                /** @var ProductVariantInterface $productVariant */
                $productVariant = $this->productVariantProvider->provide($variant->getCode());
                $productVariant->setEnabled($variant->isEnabled());
                $productVariant->setTracked(true);
                $productVariant->setOnHand($variant->getStock());

                $this->pricingAssigner->assign($variant, $productVariant);
                $this->optionAssigner->assign($variant, $productVariant, $product);

                $product->addVariant($productVariant);
            }

            $this->taxonAssigner->assign($row, $product);
            $this->channelAssigner->assign($row, $product);
            $this->imageAssigner->assign($row, $product);

            $this->productManager->persist($product);
        }

        $this->productManager->flush();

        return count($rows);
    }
}
