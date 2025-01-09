<?php

declare(strict_types=1);

namespace App\Importer;

use App\Importer\DTO\ProductOptionDTO;
use App\Importer\Provider\ResourceProvider;
use App\Importer\Provider\TranslationProvider;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionTranslation;
use Sylius\Component\Product\Model\ProductOptionTranslationInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductOptionImporter
{
    private const FILE_NAME = 'product_option_import.csv';

    private const FILE_FORMAT = 'csv';

    public function __construct(
        private Filesystem $filesystem,
        private SerializerInterface $serializer,
        private ResourceProvider $productOptionProvider,
        private TranslationProvider $translationProvider,
        private EntityManagerInterface $productOptionManager,
    ) {
    }

    public function import(): int
    {
        $csvFile = $this->filesystem->read(self::FILE_NAME);
        $rows = $this->serializer->deserialize(
            $csvFile,
            ProductOptionDTO::class . '[]',
            self::FILE_FORMAT
        );

        /** @var ProductOptionDTO $row */
        foreach ($rows as $row) {
            /** @var ProductOptionInterface $productOption */
            $productOption = $this->productOptionProvider->provide($row->getCode());

            /** @var ProductOptionTranslationInterface $productOptionTranslation */
            $productOptionTranslation = $this->translationProvider->provide(
                $productOption,
                ProductOptionTranslation::class,
                $row->getLocale()
            );
            $productOptionTranslation->setName($row->getName());
            $productOption->addTranslation($productOptionTranslation);

            $this->productOptionManager->persist($productOption);
        }

        $this->productOptionManager->flush();

        return count($rows);
    }
}
