<?php

namespace Printful\Tests\Products;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\Responses\SyncVariantResponse;
use Printful\Structures\Sync\SyncProductUpdateParameters;

class UpdateTest extends ProductsTestBase
{
    /**
     * Tests SyncProduct update
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulSdkException
     */
    public function testUpdateProduct()
    {
        $syncProduct = $this->createProduct();

        $productRequest = new SyncProductRequest;
        $productRequest->name = 'My new SDK random name ' . rand(1, 10);

        $updateParams = new SyncProductUpdateParameters;
        $updateParams->syncProduct = $productRequest;

        $updatedSyncProduct = $this->apiEndpoint->updateProduct($syncProduct->id, $updateParams);
        $this->assertInstanceOf(SyncProductResponse::class, $updatedSyncProduct);

        // check if this field is changed
        $this->assertEquals($productRequest->name, $updatedSyncProduct->name);

        // check if this field is not changed
        $this->assertEquals($syncProduct->externalId, $updatedSyncProduct->externalId);
    }

    /**
     * Tests SyncVariant update
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulSdkException
     */
    public function testUpdateVariant()
    {
        $syncProduct = $this->createProduct();
        $syncProduct = $this->apiEndpoint->getProduct($syncProduct->id);

        $variant = $syncProduct->syncVariants[0];

        $request = new SyncVariantRequest;
        $request->externalId = uniqid();

        $updatedSyncVariant = $this->apiEndpoint->updateVariant($variant->id, $request);
        $this->assertInstanceOf(SyncVariantResponse::class, $updatedSyncVariant);

        $this->assertEquals($request->externalId, $updatedSyncVariant->externalId);
    }
}