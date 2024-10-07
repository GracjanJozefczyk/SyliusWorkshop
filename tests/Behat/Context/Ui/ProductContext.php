<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui;

use App\Entity\Manufacturer\ManufacturerInterface;
use App\Tests\Behat\Page\Shop\Product\IndexPageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ProductContext implements Context
{
    public function __construct(
        private IndexPageInterface $manufacturersIndexPage,
    ) {
    }

    /**
     * @When I browse products from manufacturer :manufacturer
     */
    public function iCheckListOfProductsForManufacturer(ManufacturerInterface $manufacturer): void
    {
        $this->manufacturersIndexPage->open(['code' => $manufacturer->getCode()]);
    }

    /**
     * @Then I should see the product :productName
     */
    public function iShouldSeeProduct($productName): void
    {
        Assert::true($this->manufacturersIndexPage->isProductOnList($productName));
    }

    /**
     * @Then I should not see the product :productName
     */
    public function iShouldNotSeeProduct($productName): void
    {
        Assert::false($this->manufacturersIndexPage->isProductOnList($productName));
    }
}
