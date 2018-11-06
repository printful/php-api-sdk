<?php

namespace tests\ProductsApi;

use Printful\PrintfulProducts;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\Responses\SyncProductsPagingResponse;
use Printful\Structures\Sync\Responses\SyncProductsResponse;
use Printful\Tests\TestCase;

class GetRequestTest extends TestCase
{
    /** @var PrintfulProducts */
    private $apiEndpoint;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        $this->apiEndpoint = new PrintfulProducts($this->api);
    }

    /**
     * Tests Get SyncProduct list functionality
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGetProductList()
    {
        $result = $this->apiEndpoint->getProducts();
        $this->assertInstanceOf(SyncProductsResponse::class, $result);

        foreach ($result->result as $item) {
            $this->assertInstanceOf(SyncProductResponse::class, $item);
        }

        $this->assertInstanceOf(SyncProductsPagingResponse::class, $result->paging);
    }

    /**
     * Tests GET Single SyncProduct by ID
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGetSingleProductById()
    {
        $productsResponse = $this->apiEndpoint->getProducts();
        if (empty($productsResponse->result)) {
            $this->fail('Can\'t test getSingleProduct. No products in store');
            return;
        }

        $prod = $productsResponse->result[0];
        $result = $this->apiEndpoint->getProduct($prod->id);

        $this->assertEquals($prod, $result->syncProduct);
    }

    /**
     * Tests GET Single SyncProduct by External_id
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGetSingleProductByExternalId()
    {
        $productsResponse = $this->apiEndpoint->getProducts();
        if (empty($productsResponse->result)) {
            $this->fail('Can\'t test getSingleProduct. No products in store');
            return;
        }

        $prod = $productsResponse->result[0];
        $result = $this->apiEndpoint->getProduct('@' . $prod->externalId);

        $this->assertEquals($prod, $result->syncProduct);
    }

    /**
     * Test GET single SyncVariant by ID
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGetSingleVariantById()
    {
        $productsResponse = $this->apiEndpoint->getProducts();
        if (empty($productsResponse->result)) {
            $this->fail('Can\'t test getSingleProduct. No products in store');
            return;
        }

        $prod = $productsResponse->result[0];
        $result = $this->apiEndpoint->getProduct('@' . $prod->externalId);

        $variant = $result->syncVariants[0];

        $result = $this->apiEndpoint->getVariant($variant->id);

        $this->assertEquals($variant, $result);
    }

    /**
     * Test GET single SyncVariant by External ID
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGetSingleVariantByExternalId()
    {
        $productsResponse = $this->apiEndpoint->getProducts();
        if (empty($productsResponse->result)) {
            $this->fail('Can\'t test getSingleProduct. No products in store');
            return;
        }

        $prod = $productsResponse->result[0];
        $result = $this->apiEndpoint->getProduct('@' . $prod->externalId);

        $variant = $result->syncVariants[0];

        $result = $this->apiEndpoint->getVariant('@' . $variant->externalId);

        $this->assertEquals($variant, $result);
    }
}