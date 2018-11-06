<?php

namespace Printful;

use Printful\Factories\Sync\ParameterFactory;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\Responses\SyncProductsResponse;
use Printful\Structures\Sync\Responses\SyncVariantResponse;
use Printful\Structures\Sync\SyncProductCreationParameters;

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
     * Preforms GET SyncVariantResponse request
     *
     * @param $id
     * @return SyncVariantResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function getVariant($id)
    {
        $response = $this->printfulClient->get(PrintfulProducts::ENDPOINT_VARIANTS . '/' . $id);
        $result = SyncVariantResponse::fromArray($response);

        return $result;
    }

    /**
     * Preforms POST SyncProduct request
     *
     * @param SyncProductCreationParameters $request
     * @return SyncProductResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function createProduct(SyncProductCreationParameters $request)
    {
        $params = ParameterFactory::buildSyncProductPostParams($request);
        $response = $this->printfulClient->post(PrintfulProducts::ENDPOINT_PRODUCTS, $params);

        $result = $response['result'];
        $syncProduct = SyncProductResponse::fromArray($result);

        return $syncProduct;
    }
}
