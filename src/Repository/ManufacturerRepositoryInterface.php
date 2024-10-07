<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Manufacturer\ManufacturerInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

interface ManufacturerRepositoryInterface extends RepositoryInterface
{
    public function finOneByCode(string $code): ?ManufacturerInterface;
}
