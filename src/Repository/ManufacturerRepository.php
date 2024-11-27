<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Manufacturer\ManufacturerInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

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

    public function createByChannelQueryBuilder(ChannelInterface $channel): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere(':channel MEMBER OF o.channels')
            ->setParameter('channel', $channel)
            ->getQuery()
            ->getResult()
        ;
    }
}
