<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Manufacturer\ManufacturerInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

final class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    public function findByManufacturer(ManufacturerInterface $manufacturer): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.manufacturer = :manufacturer')
            ->setParameter('manufacturer', $manufacturer)
            ->getQuery()
            ->getResult()
        ;
    }
}
