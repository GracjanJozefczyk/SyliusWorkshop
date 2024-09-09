<?php

declare(strict_types=1);

namespace App\Cli;

use App\Entity\Manufacturer\ManufacturerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

final class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    public function __construct(
        private RepositoryInterface $manufacturerRepository,
        private FactoryInterface $manufacturerFactory,
        private EntityManagerInterface $manufacturerManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $manufacturerCode = 'SAMSUNG';

        $manufacturer = $this->manufacturerRepository->findOneBy([
            'code' => $manufacturerCode
        ]);

        if ($manufacturer instanceof ManufacturerInterface) {
            $output->writeln('Manufacturer already exists');
            $output->writeln('Manufacturer code: ' . $manufacturer->getCode());
            $output->writeln('Created at: ' . $manufacturer->getCreatedAt()->format('Y-m-d H:i:s'));

            return Command::SUCCESS;
        }

        $manufacturer = $this->manufacturerFactory->createNew();
        Assert::isInstanceOf($manufacturer, ManufacturerInterface::class);

        $manufacturer->setCode($manufacturerCode);

        $this->manufacturerManager->persist($manufacturer);
        $this->manufacturerManager->flush();

        $output->writeln('Manufacturer successfully created');
        $output->writeln('Manufacturer code: ' . $manufacturer->getCode());
        $output->writeln('Created at: ' . $manufacturer->getCreatedAt()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
