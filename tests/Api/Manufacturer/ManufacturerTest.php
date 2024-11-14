<?php

declare(strict_types=1);

namespace App\Tests\Api\Manufacturer;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ManufacturerTest extends ApiTestCase
{
    public function test_it_gets_shop_manufacturers(): void
    {
        $this->loadFixturesFromFile('Manufacturer/manufacturers.yaml');

        $this->client->request(
            'GET',
            '/api/v2/shop/manufacturers',
            [],
            [],
            self::CONTENT_TYPE_HEADER,
            json_encode([]),
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'Manufacturer/shop_manufacturers_response',
            Response::HTTP_OK,
        );
    }
}
