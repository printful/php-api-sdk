<?php

namespace Printful\Tests\ProductsApi;

use Printful\PrintfulProducts;
use Printful\Tests\TestCase;

abstract class ProductsApiTestBase extends TestCase
{
    /** @var PrintfulProducts */
    protected $apiEndpoint;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        $this->apiEndpoint = new PrintfulProducts($this->api);
    }
}