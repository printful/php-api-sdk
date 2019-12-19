<?php

namespace Printful\Tests\Catalog;

use Printful\PrintfulCatalog;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\SyncProductCreationParameters;
use Printful\Tests\TestCase;

abstract class CatalogTestBase extends TestCase
{
    /** @var PrintfulCatalog */
    protected $apiEndpoint;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();
        $this->apiEndpoint = new PrintfulCatalog($this->api);
    }

//    /**
//     * Returns POST product data in array format
//     *
//     * @return array
//     */
//    protected function getPostProductData()
//    {
//        return [
//            'sync_product' => [
//                'name' => 'SDK Test name',
//                'thumbnail' => 'https://picsum.photos/200/300',
//            ],
//            'sync_variants' => [
//                [
//                    'retail_price' => 21.00,
//                    'variant_id' => 4011,
//                    'files' => [
//                        [
//                            'url' => 'https://picsum.photos/200/300',
//                        ],
//                        [
//                            'type' => 'back',
//                            'url' => 'https://picsum.photos/200/300',
//                        ],
//                    ],
//                    'options' => [
//                        [
//                            'id' => 'embroidery_type',
//                            'value' => 'flat',
//                        ],
//                        [
//                            'id' => 'thread_colors',
//                            'value' => '',
//                        ],
//                    ],
//                ],
//                [
//                    'retail_price' => 21,
//                    'variant_id' => 4012,
//                    'files' => [
//                        [
//                            'url' => 'https://picsum.photos/200/300',
//                        ],
//                        [
//                            'type' => 'back',
//                            'url' => 'https://picsum.photos/200/300',
//                        ],
//                    ],
//                    'options' => [
//                        [
//                            'id' => 'embroidery_type',
//                            'value' => 'flat',
//                        ],
//                        [
//                            'id' => 'thread_colors',
//                            'value' => '',
//                        ],
//                    ],
//                ],
//            ],
//        ];
//    }
//
//    protected function getPostVariantData()
//    {
//        return [
//            'retail_price' => 21.00,
//            'variant_id' => 4011,
//            'files' => [
//                [
//                    'url' => 'https://picsum.photos/200/300',
//                ],
//                [
//                    'type' => 'back',
//                    'url' => 'https://picsum.photos/200/300',
//                ],
//            ],
//            'options' => [
//                [
//                    'id' => 'embroidery_type',
//                    'value' => 'flat',
//                ],
//                [
//                    'id' => 'thread_colors',
//                    'value' => '',
//                ],
//            ],
//        ];
//    }
//
//    /**
//     * Creates SyncProduct
//     *
//     * @return SyncProductResponse
//     * @throws \Printful\Exceptions\PrintfulApiException
//     * @throws \Printful\Exceptions\PrintfulException
//     */
//    protected function createProduct()
//    {
//        $data = $this->getPostProductData();
//        $params = SyncProductCreationParameters::fromArray($data);
//
//        $result = $this->apiEndpoint->createProduct($params);
//
//        return $result;
//    }
}