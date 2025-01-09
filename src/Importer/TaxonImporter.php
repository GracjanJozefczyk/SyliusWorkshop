<?php

declare(strict_types=1);

namespace App\Importer;

use App\Importer\DTO\TaxonDTO;
use App\Importer\Provider\ResourceProvider;
use App\Importer\Provider\TranslationProvider;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonTranslation;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class TaxonImporter
{
    private const FILE_NAME = 'taxon_import.csv';

    private const FILE_FORMAT = 'csv';

    public function __construct(
        private Filesystem $filesystem,
        private SerializerInterface $serializer,
        private ResourceProvider $taxonProvider,
        private TranslationProvider $taxonTranslationProvider,
        private EntityManagerInterface $taxonManager,
    ) {
    }

    public function import(): int
    {
        $csvFile = $this->filesystem->read(self::FILE_NAME);
        $rows = $this->serializer->deserialize(
            $csvFile,
            TaxonDTO::class . '[]',
            self::FILE_FORMAT
        );

        /** @var TaxonDTO $row */
        foreach ($rows as $row) {
            /** @var TaxonInterface $taxon */
            $taxon = $this->taxonProvider->provide($row->getCode());

            /** @var TaxonTranslationInterface $taxonTranslation */
            $taxonTranslation = $this->taxonTranslationProvider->provide($taxon, TaxonTranslation::class, $row->getLocale());
            $taxonTranslation->setName($row->getName());
            $taxonTranslation->setDescription($row->getDescription());
            $taxonTranslation->setSlug(StringInflector::nameToSlug($row->getName()));
            $taxon->addTranslation($taxonTranslation);

            if (!empty($row->getParent())) {
                /** @var TaxonInterface $parent */
                $parent = $this->taxonProvider->provide($row->getParent(), false);
                $taxon->setParent($parent);
            }

            $this->taxonManager->persist($taxon);
        }

        $this->taxonManager->flush();

        return count($rows);
    }
}
