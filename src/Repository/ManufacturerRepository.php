<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Manufacturer\ManufacturerInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class ManufacturerRepository extends EntityRepository implements ManufacturerRepositoryInterface
{
    public function finOneByCode(string $code): ?ManufacturerInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
