<?php

declare(strict_types=1);

namespace App\Importer\Assigner;

use App\Importer\DTO\ProductDTO;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Sylius\Component\Core\Filesystem\Adapter\FilesystemAdapterInterface;
use Sylius\Component\Core\Model\ProductImageInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class ImageAssigner
{
    public function __construct(
        private FilesystemAdapterInterface $filesystem,
        private RequestFactoryInterface $requestFactory,
        private ClientInterface $client,
        private FactoryInterface $factory,
    ) {
    }

    public function assign(ProductDTO $productDTO, ProductInterface $product): void
    {
        foreach ($productDTO->getImages() as $path) {
            $relativePath = basename($path);
            $this->copyImage($path, $relativePath);
            $this->assignImage($product, $relativePath);
        }
    }

    private function copyImage(string $path, string $relativePath): void
    {
        if ($this->filesystem->has($relativePath)) {
            return;
        }

        $request = $this->requestFactory
            ->createRequest(Request::METHOD_GET, $path)
            ->withHeader('Content-Type', 'application/json')
        ;

        $response = $this->client->sendRequest($request);
        $this->filesystem->write($relativePath, $response->getBody()->getContents());
    }

    private function assignImage(ProductInterface $product, string $relativePath): void
    {
        if (true === $this->hasImage($product, $relativePath)) {
            return;
        }

        /** @var ProductImageInterface $productImage */
        $productImage = $this->factory->createNew();
        $productImage->setPath($relativePath);
        $product->addImage($productImage);
    }

    private function hasImage(ProductInterface $product, string $relativePath): bool
    {
        foreach ($product->getImages() as $image) {
            if ($image->getPath() === $relativePath) {
                return true;
            }
        }

        return false;
    }
}
