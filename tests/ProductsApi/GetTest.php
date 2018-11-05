<?php

namespace tests\ProductsApi;

use Printful\PrintfulProducts;
use Printful\Tests\TestCase;

class GetTest extends TestCase
{

    /** @var PrintfulProducts */
    private $products;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        $this->products = new PrintfulProducts($this->api);
    }

    /**
     * Tests Get SyncProduct list functionality
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGetProductList()
    {
//        $result = $this->products->getProducts();
    }
}