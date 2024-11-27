<?php

declare(strict_types=1);

namespace App\Api\Doctrine\QueryCollectionExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\ContextAwareQueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface as LegacyQueryNameGeneratorInterface;
use App\Entity\Manufacturer\ManufacturerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ApiBundle\Context\UserContextInterface;
use Sylius\Bundle\ApiBundle\Serializer\ContextKeys;
use Webmozart\Assert\Assert;

final class ManufacturersByChannelExtension implements ContextAwareQueryCollectionExtensionInterface
{
    public function __construct(
        private UserContextInterface $userContext
    ) {
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        LegacyQueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null,
        array $context = []
    ): void {
        if (!is_a($resourceClass, ManufacturerInterface::class, true)) {
            return;
        }

        $user = $this->userContext->getUser();
        if ($user !== null && in_array('ROLE_API_ACCESS', $user->getRoles(), true)) {
            return;
        }

        Assert::keyExists($context, ContextKeys::CHANNEL);
        $channel = $context[ContextKeys::CHANNEL];

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $channelsParameterName = $queryNameGenerator->generateParameterName('channel');

        $queryBuilder
            ->andWhere(sprintf(':%s MEMBER OF %s.channels', $channelsParameterName, $rootAlias))
            ->setParameter($channelsParameterName, $channel)
        ;
    }
}
