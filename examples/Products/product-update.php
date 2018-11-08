<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\Exceptions\PrintfulSdkException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\SyncProductUpdateParameters;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to update Product using Products Api
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#actionUpdateProduct
 */

// Replace this with your API key
$apiKey = '';

// Example A

try {

    // product id in Printful store, which we want to update
    $productId = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $productId = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // build update params manually
    $params = new SyncProductUpdateParameters;

    // build product request manually
    $productRequest = new SyncProductRequest;

    // in this example we only need to update this one field, so we omit rest
    $productRequest->name = 'My new shirt name';

    // in this example we only need to update products info, so we omit variant list info
    $params->syncProduct = $productRequest;

    // preform update
    $product = $productsApi->updateProduct($productId, $params);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}

// Example B
try {

    // product id in Printful store, which we want to update
    $productId = 1;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // build product request from array
    $productRequest = SyncProductRequest::fromArray([
        'name' => 'My new shirt name',
    ]);

    $params = new SyncProductUpdateParameters;

    // in this example we only need to update products info, so we omit variant list info
    $params->syncProduct = $productRequest;

    // preform update
    $product = $productsApi->updateProduct($productId, $params);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}

// Example C
try {

    // product id in Printful store, which we want to update
    $productId = 1;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // build params from array
    $params = SyncProductUpdateParameters::fromArray([
        'sync_product' => [
            'name' => 'My new shirt name',
        ],
    ]);

    // preform update
    $product = $productsApi->updateProduct($productId, $params);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}