<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Responses\SyncVariantResponse;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to get a single Variant using id and external id
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#getSingleSyncVariant
 */

// Replace this with your API key
$apiKey = '';

try {
    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // variant id in your Printful store
    $variantId = 1;

    // get variant by id
    /** @var SyncVariantResponse $product */
    $product = $productsApi->getProduct($variantId);


    // variant id in your store(saved with external_id)
    $externalVariantId = 15946;

    // get variant by external_id
    /** @var SyncVariantResponse $product */
    $product = $productsApi->getProduct('@' . $externalVariantId);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
