<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Shop\Product;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_shop_manufactured_products_index';
    }

    public function isProductOnList(string $productName): bool
    {
        try {
            $this->getElement('product_name', ['%productName%' => $productName]);
        } catch (ElementNotFoundException) {
            return false;
        }

        return true;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'product_name' => '[data-test-product-name="%productName%"]',
            'products' => '[data-test-products]',
        ]);
    }
}
