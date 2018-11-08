<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Responses\SyncProductRequestResponse;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to get a single Product using id and external id
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#getSingleSyncProduct
 */

// Replace this with your API key
$apiKey = '';

try {
    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // product id in your Printful store
    $productId = 1;

    // get product by id
    /** @var SyncProductRequestResponse $response */
    $response = $productsApi->getProduct($productId);

    // actual product can be found $response->syncProduct
    // and its variants $response->syncVariants

    // product id in your store(saved with external_id)
    $externalProductId = 15946;

    // get product by external_id
    /** @var SyncProductRequestResponse $response */
    $response = $productsApi->getProduct('@' . $externalProductId);

    // actual product can be found $response->syncProduct
    // and products variants $response->syncVariants

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
