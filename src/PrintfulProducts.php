<?php

namespace Printful;

use Printful\Structures\Sync\SyncProductResponse;
use Printful\Structures\Sync\SyncProductsResponse;
use Printful\Structures\Sync\SyncVariant;

/**
 * Class PrintfulProducts
 *
 * @package Printful
 */
class PrintfulProducts
{
    const ENDPOINT_PRODUCTS = '/store/products';
    const ENDPOINT_VARIANTS = '/store/variants';

    /**
     * @var PrintfulApiClient
     */
    private $printfulClient;

    /**
     * @param PrintfulApiClient $printfulClient
     */
    public function __construct(PrintfulApiClient $printfulClient)
    {
        $this->printfulClient = $printfulClient;
    }

    /**
     * Preforms GET SyncProducts request
     *
     * @param int $offset
     * @param int $limit
     * @return SyncProductsResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function getProducts($offset = 0, $limit = 20)
    {
        $requestData = [
            'offset' => (int)$offset,
            'limit' => (int)$limit,
        ];

        $response = $this->printfulClient->get(PrintfulProducts::ENDPOINT_PRODUCTS, $requestData);
        $result = SyncProductsResponse::fromArray($response);

        return $result;
    }

    /**
     * Preforms GET SyncProduct request
     *
     * @param $id
     * @return SyncProductResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function getProduct($id)
    {
        $response = $this->printfulClient->get(PrintfulProducts::ENDPOINT_PRODUCTS . '/' . $id);
        $result = SyncProductResponse::fromArray($response);

        return $result;
    }

    /**
     * Preforms GET SyncVariant request
     *
     * @param $id
     * @return SyncVariant
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function getVariant($id)
    {
        $response = $this->printfulClient->get(PrintfulProducts::ENDPOINT_VARIANTS . '/' . $id);
        $result = SyncVariant::fromArray($response);

        return $result;
    }
}
