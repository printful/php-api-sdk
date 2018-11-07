<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProductsApi;

require_once __DIR__ . '../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to update Product using Products Api
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#actionUpdateProduct
 */

// Replace this with your API key
$apiKey = '';

// Delete product example
try {

    // product id in Printful store, which we want to delete
    $id = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $id = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProductsApi($pf);

    $productsApi->deleteProduct($id);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}

// Delete variant example
try {

    // variant id in Printful store, which we want to delete
    // remember that you can not delete products last variant, you should delete whole product instead
    $id = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $id = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProductsApi($pf);

    $productsApi->deleteVariant($id);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}