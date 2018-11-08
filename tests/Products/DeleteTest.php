<?php

namespace Printful\Tests\Products;

use Printful\Exceptions\PrintfulApiException;

class DeleteTest extends ProductsTestBase
{
    /**
     * Tests SyncProduct deletion
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testProductDelete()
    {
        $product = $this->createProduct();
        $this->apiEndpoint->deleteProduct($product->id);

        // expect 404
        $this->expectException(PrintfulApiException::class);

        $this->apiEndpoint->getProduct($product->id);
    }

    /**
     * Test SyncVariant deletion
     *
     * @throws PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testVariantDelete()
    {
        $this->expectException(PrintfulApiException::class);

        $product = $this->createProduct(false);
        $product = $this->apiEndpoint->getProduct($product->id);
        $variant = $product->syncVariants[0];

        $this->apiEndpoint->deleteVariant($variant->id);

        // expect 404
        $this->expectException(PrintfulApiException::class);

        $this->apiEndpoint->getVariant($variant->id);
    }
}
