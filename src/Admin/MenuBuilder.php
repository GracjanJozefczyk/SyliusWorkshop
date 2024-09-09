<?php

declare(strict_types=1);

namespace App\Admin;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class MenuBuilder
{
    public function __invoke(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $catalog = $menu->getChild('catalog');

        if (null === $catalog) {
            return;
        }

        $catalog
            ->addChild('manufacturers', [
                'route' => 'sylius_admin_manufacturer_index',
            ])
            ->setLabel('sylius.ui.manufacturers')
            ->setLabelAttribute('icon', 'tag')
        ;
    }
}
