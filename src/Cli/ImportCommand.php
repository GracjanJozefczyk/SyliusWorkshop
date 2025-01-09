<?php

declare(strict_types=1);

namespace App\Cli;

use App\Importer\ProductAttributeImporter;
use App\Importer\ProductImporter;
use App\Importer\ProductOptionImporter;
use App\Importer\TaxonImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCommand extends Command
{
    protected static $defaultName = 'app:import';

    public function __construct(
        private TaxonImporter $taxonImporter,
        private ProductOptionImporter $productOptionImporter,
        private ProductAttributeImporter $productAttributeImporter,
        private ProductImporter $productImporter,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeln('Importing taxons...');

            $importedRows = $this->taxonImporter->import();

            $output->writeln("Imported $importedRows rows");

            $output->writeln('Importing product option...');

            $importedRows = $this->productOptionImporter->import();

            $output->writeln("Imported $importedRows rows");

            $output->writeln('Importing product attributes...');

            $importedRows = $this->productAttributeImporter->import();

            $output->writeln("Imported $importedRows rows");

            $output->writeln('Importing products...');

            $importedRows = $this->productImporter->import();

            $output->writeln("Imported $importedRows rows");
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
