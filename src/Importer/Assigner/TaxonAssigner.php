<?php

declare(strict_types=1);

namespace App\Importer\Assigner;

use App\Importer\DTO\ProductDTO;
use App\Importer\Provider\ResourceProvider;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Resource\Factory\FactoryInterface;

final class TaxonAssigner
{
    public function __construct(
        private ResourceProvider $taxonProvider,
        private FactoryInterface $productTaxonFactory,
    ) {
    }

    public function assign(ProductDTO $productDTO, ProductInterface $product): void
    {
        /** @var TaxonInterface $mainTaxon */
        $mainTaxon = $this->taxonProvider->provide($productDTO->getMainTaxon(), false);
        $product->setMainTaxon($mainTaxon);

        foreach ($productDTO->getTaxons() as $taxonCode) {
            if ($this->hasProductTaxon($product, $taxonCode)) {
                continue;
            }

            /** @var TaxonInterface $taxon */
            $taxon = $this->taxonProvider->provide($taxonCode, false);

            /** @var ProductTaxonInterface $productTaxon */
            $productTaxon = $this->productTaxonFactory->createNew();
            $productTaxon->setProduct($product);
            $productTaxon->setTaxon($taxon);
            $product->addProductTaxon($productTaxon);
        }
    }

    private function hasProductTaxon(ProductInterface $product, string $taxonCode): bool
    {
        foreach ($product->getProductTaxons() as $productTaxon) {
            if ($productTaxon->getTaxon()?->getCode() === $taxonCode) {
                return true;
            }
        }

        return false;
    }
}
