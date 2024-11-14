<?php

declare(strict_types=1);

namespace App\Tests\Unit\Admin;

use App\Admin\MenuBuilder;
use Knp\Menu\ItemInterface;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class MenuBuilderTest extends TestCase
{
    public function test_it_builds_menu(): void
    {
        $menuBuilder = new MenuBuilder();

        $catalog = self::createMock(ItemInterface::class);
        $catalog
            ->expects(self::once())
            ->method('addChild')
            ->with('manufacturers', [
                'route' => 'sylius_admin_manufacturer_index',
            ])
            ->willReturnSelf()
        ;
        $catalog
            ->expects(self::once())
            ->method('setLabel')
            ->with('sylius.ui.manufacturers')
            ->willReturnSelf()
        ;
        $catalog
            ->expects(self::once())
            ->method('setLabelAttribute')
            ->with('icon', 'tag')
            ->willReturnSelf()
        ;

        $menu = self::createMock(ItemInterface::class);
        $menu
            ->expects(self::once())
            ->method('getChild')
            ->with('catalog')
            ->willReturn($catalog)
        ;

        $event = self::createMock(MenuBuilderEvent::class);
        $event
            ->expects(self::once())
            ->method('getMenu')
            ->willReturn($menu)
        ;

        $menuBuilder->__invoke($event);
    }

    public function test_it_does_not_build_menu_if_catalog_is_null(): void
    {
        $menuBuilder = new MenuBuilder();

        $menu = self::createMock(ItemInterface::class);
        $menu
            ->expects(self::once())
            ->method('getChild')
            ->with('catalog')
            ->willReturn(null)
        ;

        $event = self::createMock(MenuBuilderEvent::class);
        $event
            ->expects(self::once())
            ->method('getMenu')
            ->willReturn($menu)
        ;

        $menuBuilder->__invoke($event);
    }
}
