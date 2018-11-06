<?php

namespace Printful\Tests\ProductsApi;

use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\SyncProductCreationParameters;

class CreateProductTest extends ProductsApiTestBase
{
    /**
     * Tests SyncProduct creation via API
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testCreateProduct()
    {
        $data = $this->getPostProductData();

        $params = SyncProductCreationParameters::fromArray($data);

        $result = $this->apiEndpoint->createProduct($params);
        $this->assertInstanceOf(SyncProductResponse::class, $result);
    }
}
