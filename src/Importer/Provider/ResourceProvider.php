<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Sylius\Resource\Model\CodeAwareInterface;

final class ResourceProvider
{
    private array $resources = [];

    public function __construct(
        private RepositoryInterface $repository,
        private FactoryInterface $factory,
    ) {
    }

    public function provide(string $code, bool $createNew = true): CodeAwareInterface
    {
        $resource = $this->resources[$code] ?? null;
        if ($resource instanceof CodeAwareInterface) {
            return $resource;
        }

        $resource = $this->repository->findOneBy(['code' => $code]);
        if ($resource instanceof CodeAwareInterface) {
            $this->resources[$code] = $resource;
            return $resource;
        }

        if (false === $createNew) {
            throw new \Exception("Resource with code $code was not found.");
        }

        /** @var CodeAwareInterface $resource */
        $resource = $this->factory->createNew();
        $resource->setCode($code);
        $this->resources[$code] = $resource;

        return $resource;
    }
}
