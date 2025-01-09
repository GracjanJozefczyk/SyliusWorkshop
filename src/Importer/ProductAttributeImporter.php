<?php

declare(strict_types=1);

namespace App\Importer;

use App\Importer\DTO\ProductAttributeDTO;
use App\Importer\Provider\ResourceProvider;
use App\Importer\Provider\TranslationProvider;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use Ramsey\Uuid\Uuid;
use Sylius\Component\Attribute\AttributeType\AttributeTypeInterface;
use Sylius\Component\Attribute\AttributeType\SelectAttributeType;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Sylius\Component\Product\Model\ProductAttributeTranslation;
use Sylius\Component\Product\Model\ProductAttributeTranslationInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductAttributeImporter
{
    private const FILE_NAME = 'attribute_import.json';

    private const FILE_FORMAT = 'json';

    public function __construct(
        private Filesystem $filesystem,
        private SerializerInterface $serializer,
        private ResourceProvider $provider,
        private TranslationProvider $translationProvider,
        private ServiceRegistryInterface $attributeTypesRegistry,
        private EntityManagerInterface $productAttributeManager,
    ) {
    }

    public function import(): int
    {
        $file = $this->filesystem->read(self::FILE_NAME);
        $rows = $this->serializer->deserialize(
            $file,
            ProductAttributeDTO::class . '[]',
            self::FILE_FORMAT
        );

        /** @var ProductAttributeDTO $row */
        foreach ($rows as $row) {
            /** @var AttributeTypeInterface $attributeType */
            $attributeType = $this->attributeTypesRegistry->get($row->getType());

            /** @var ProductAttributeInterface $productAttribute */
            $productAttribute = $this->provider->provide($row->getCode());
            $productAttribute->setType($attributeType->getType());
            $productAttribute->setStorageType($attributeType->getStorageType());

            if ($productAttribute->getType() === SelectAttributeType::TYPE) {
                $productAttribute->setConfiguration($this->resolveValues($row->getChoices()));
            }

            foreach ($row->getTranslations() as $locale => $translation) {
                /** @var ProductAttributeTranslationInterface $productAttributeTranslation */
                $productAttributeTranslation = $this->translationProvider->provide(
                    $productAttribute,
                    ProductAttributeTranslation::class,
                    $locale
                );
                $productAttributeTranslation->setName($translation['name']);
                $productAttribute->addTranslation($productAttributeTranslation);
            }

            $this->productAttributeManager->persist($productAttribute);
        }

        $this->productAttributeManager->flush();

        return count($rows);
    }

    private function resolveValues(array $choices): array
    {
        $result = ['choices' => [], 'multiple' => false];

        foreach ($choices as $choice) {
            $key = Uuid::uuid1()->toString();

            foreach ($choice as $locale => $value) {
                $result['choices'][$key][$locale] = $value;
            }
        }

        return $result;
    }
}
