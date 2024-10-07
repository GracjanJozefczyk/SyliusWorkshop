<?php

namespace App\Tests\Behat\Page\Shop\Product;

use FriendsOfBehat\PageObjectExtension\Page\PageInterface;

interface IndexPageInterface extends PageInterface
{
    public function isProductOnList(string $productName): bool;
}
