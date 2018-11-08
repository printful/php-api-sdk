<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Responses\SyncProductsResponse;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to get list of products in your store using Products API
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#listProducts
 */


// Replace this with your API key
$apiKey = '';

try {
    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // set some paging info
    $offset = 0;
    $limit = 20;

    /** @var SyncProductsResponse $list */
    $list = $productsApi->getProducts($offset, $limit);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
