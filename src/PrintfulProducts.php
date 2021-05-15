<?php

namespace Printful;

use Printful\Structures\Sync\Requests\SyncVariantRequest;
use Printful\Structures\Sync\Responses\SyncProductRequestResponse;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\Responses\SyncProductsResponse;
use Printful\Structures\Sync\Responses\SyncVariantResponse;
use Printful\Structures\Sync\SyncProductCreationParameters;
use Printful\Structures\Sync\SyncProductUpdateParameters;

/**
 * Class PrintfulProducts
 *
 * API Docs: https://www.printful.com/docs/products
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
    public function getProducts($offset = 0, $limit = 20, $status = 'all', $search = '')
    {
        $requestData = [
            'offset' => (int)$offset,
            'limit'  => (int)$limit,
            'status' => (string)$status,
            'search' => (string)$search,
        ];

        $response = $this->printfulClient->get(PrintfulProducts::ENDPOINT_PRODUCTS, $requestData);
        $lastResponse = $this->printfulClient->getLastResponse();

        // as paging block is omitted in $response;
        $responseArray = [
            'result' => $response,
            'paging' => $lastResponse['paging'],
        ];
        $result = SyncProductsResponse::fromArray($responseArray);

        return $result;
    }

    /**
     * Preforms GET SyncProduct request
     *
     * @param $id
     * @return SyncProductRequestResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function getProduct($id)
    {
        $response = $this->printfulClient->get(PrintfulProducts::ENDPOINT_PRODUCTS . '/' . $id);
        $result = SyncProductRequestResponse::fromArray($response);

        return $result;
    }

    /**
     * Preforms GET SyncVariant request
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
     * @throws Exceptions\PrintfulSdkException
     * @throws Exceptions\PrintfulException
     */
    public function createProduct(SyncProductCreationParameters $request)
    {
        $params = $request->toPostArray();
        $result = $this->printfulClient->post(PrintfulProducts::ENDPOINT_PRODUCTS, $params);

        $syncProduct = SyncProductResponse::fromArray($result);

        return $syncProduct;
    }

    /**
     * Preforms POST SyncVariant request
     *
     * @param string $productId
     * @param SyncVariantRequest $syncVariantRequest
     * @return SyncVariantResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     * @throws Exceptions\PrintfulSdkException
     */
    public function createVariant($productId, SyncVariantRequest $syncVariantRequest)
    {
        $params = $syncVariantRequest->toPostArray();
        $result = $this->printfulClient->post(PrintfulProducts::ENDPOINT_PRODUCTS . '/' . $productId . '/variants', $params);

        $syncVariant = SyncVariantResponse::fromArray($result);

        return $syncVariant;
    }

    /**
     * Preforms PUT SyncProduct request
     *
     * @param string $productId
     * @param SyncProductUpdateParameters $request
     * @return SyncProductResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     * @throws Exceptions\PrintfulSdkException
     */
    public function updateProduct($productId, SyncProductUpdateParameters $request)
    {
        $params = $request->toPutArray();
        $result = $this->printfulClient->put(PrintfulProducts::ENDPOINT_PRODUCTS . '/' . $productId, $params);

        $syncProduct = SyncProductResponse::fromArray($result);

        return $syncProduct;
    }

    /**
     * Preforms PUT SyncVariant request
     *
     * @param string $variantId
     * @param SyncVariantRequest $request
     * @return SyncVariantResponse
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     * @throws Exceptions\PrintfulSdkException
     */
    public function updateVariant($variantId, SyncVariantRequest $request)
    {
        $params = $request->toPutArray();
        $result = $this->printfulClient->put(PrintfulProducts::ENDPOINT_VARIANTS . '/' . $variantId, $params);

        $syncVariant = SyncVariantResponse::fromArray($result);

        return $syncVariant;
    }

    /**
     * Preforms DELETE SyncProduct request
     *
     * @param $productId
     * @return mixed
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function deleteProduct($productId)
    {
        return $this->printfulClient->delete(PrintfulProducts::ENDPOINT_PRODUCTS . '/' . $productId);
    }

    /**
     * Preforms DELETE SyncVariant request
     *
     * @param $variantId
     * @return mixed
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function deleteVariant($variantId)
    {
        return $this->printfulClient->delete(PrintfulProducts::ENDPOINT_VARIANTS . '/' . $variantId);
    }
}
