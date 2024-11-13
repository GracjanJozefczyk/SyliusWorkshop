<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use App\Entity\Manufacturer\ManufacturerInterface;
use App\Repository\ManufacturerRepositoryInterface;

final class ManufacturerRepositoryTest extends JsonApiTestCase
{
    private ManufacturerRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->getContainer()->get('sylius.manager.manufacturer');
        $this->repository = $this->getContainer()->get('sylius.repository.manufacturer');
    }

    public function test_it_finds_manufacturer_by_code(): void
    {
        $this->loadFixturesFromFile('ManufacturerRepository/test_it_finds_manufacturer_by_code.yaml');

        $result = $this->repository->finOneByCode('manufacturer_1');

        self::assertInstanceOf(ManufacturerInterface::class, $result);
        self::assertSame('manufacturer_1', $result->getCode());
        self::assertSame('Manufacturer 1', $result->getName());
    }
}
