<?php

declare(strict_types=1);

namespace App\Cli;

use App\Importer\ManufacturerImporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    public function __construct(
        private ManufacturerImporterInterface $manufacturerImporter,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->manufacturerImporter->import();

        return Command::SUCCESS;
    }
}
