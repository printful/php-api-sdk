<?php

namespace Printful\Tests\ProductsApi;

use Printful\Structures\Sync\Requests\SyncVariantRequest;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\Responses\SyncVariantResponse;
use Printful\Structures\Sync\SyncProductCreationParameters;

class CreateTest extends ProductsApiTestBase
{
    /**
     * Tests SyncProduct creation
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testCreateProduct()
    {
        $result = $this->createProduct();
        $this->assertInstanceOf(SyncProductResponse::class, $result);
    }

    /**
     * Tests SyncVariant creation
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulSdkException
     */
    public function testCreateVariant()
    {
        $createProductResult = $this->createProduct();

        $data = $this->getPostVariantData();
        $syncVariantRequest = SyncVariantRequest::fromArray($data);

        $result = $this->apiEndpoint->createVariant($createProductResult->id, $syncVariantRequest);
        $this->assertInstanceOf(SyncVariantResponse::class, $result);

        $syncProduct = $this->apiEndpoint->getProduct($createProductResult->id);

        // count has increased by 1
        $this->assertEquals($createProductResult->variants + 1, count($syncProduct->syncVariants));
    }

    /**
     * Creates SyncProduct and caches result
     *
     * @return SyncProductResponse
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    private function createProduct()
    {
        static $result;

        if ($result) {
            return $result;
        }

        $data = $this->getPostProductData();
        $params = SyncProductCreationParameters::fromArray($data);

        $result = $this->apiEndpoint->createProduct($params);

        return $result;
    }
}
