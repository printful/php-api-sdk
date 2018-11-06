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

    /**
     * Returns POST product data in array format
     *
     * @return array
     */
    protected function getPostProductData()
    {
        return [
            'sync_product' => [
                'name' => 'SDK Test name',
                'thumbnail' => 'https://picsum.photos/200/300',
            ],
            'sync_variants' => [
                [
                    'retail_price' => 21.00,
                    'variant_id' => 4011,
                    'files' => [
                        [
                            'url' => 'https://picsum.photos/200/300',
                        ],
                        [
                            'type' => 'back',
                            'url' => 'https://picsum.photos/200/300',
                        ],
                    ],
                    'options' => [
                        [
                            'id' => 'embroidery_type',
                            'value' => 'flat',
                        ],
                        [
                            'id' => 'thread_colors',
                            'value' => '',
                        ],
                    ],
                ],
                [
                    'retail_price' => 21,
                    'variant_id' => 4012,
                    'files' => [
                        [
                            'url' => 'https://picsum.photos/200/300',
                        ],
                        [
                            'type' => 'back',
                            'url' => 'https://picsum.photos/200/300',
                        ],
                    ],
                    'options' => [
                        [
                            'id' => 'embroidery_type',
                            'value' => 'flat',
                        ],
                        [
                            'id' => 'thread_colors',
                            'value' => '',
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getPostVariantData()
    {
        return [
            'retail_price' => 21.00,
            'variant_id' => 4011,
            'files' => [
                [
                    'url' => 'https://picsum.photos/200/300',
                ],
                [
                    'type' => 'back',
                    'url' => 'https://picsum.photos/200/300',
                ],
            ],
            'options' => [
                [
                    'id' => 'embroidery_type',
                    'value' => 'flat',
                ],
                [
                    'id' => 'thread_colors',
                    'value' => '',
                ],
            ],
        ];
    }
}