<?php

declare(strict_types=1);

namespace App\Importer\Provider;

use Sylius\Resource\Model\TranslatableInterface;
use Sylius\Resource\Model\TranslationInterface;

final class TranslationProvider
{
    public function provide(TranslatableInterface $resource, string $class, string $locale): TranslationInterface
    {
        $translation = $resource->getTranslation($locale);
        if ($locale === $translation->getLocale()) {
            return $translation;
        }

        /** @var TranslationInterface $translation */
        $translation = new $class();
        $translation->setLocale($locale);

        return $translation;
    }
}
