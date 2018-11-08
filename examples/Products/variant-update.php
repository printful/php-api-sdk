<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\Exceptions\PrintfulSdkException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to update Variant using Products Api
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#actionUpdateVariant
 */

// Replace this with your API key
$apiKey = '';

// Example A
try {

    // variant id in Printful store, which we want to update
    $variantId = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $variantId = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    $variantRequest = new SyncVariantRequest;

    // in this example we only update retail price, so we omit everything else
    $variantRequest->retailPrice = 22.00;

    $updatedVariant = $productsApi->updateVariant($variantId, $variantRequest);

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

    // variant id in Printful store, which we want to update
    $variantId = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $variantId = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // in this example we only update retail price, so we omit everything else
    $variantRequest = SyncVariantRequest::fromArray([
        'retail_price' => 22.00
    ]);

    $updatedVariant = $productsApi->updateVariant($variantId, $variantRequest);

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

    // variant id in Printful store, which we want to update
    $variantId = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $variantId = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // in this example we only update retail price and files, so we omit everything else
    $variantRequest = SyncVariantRequest::fromArray([
        'retail_price' => 22.00,
        'files' => [ // if we provide `files`, we should mention all files. All missing files will be removed
            [
                'url' => 'https://www.my-webshop.com/shirt.jpg',
            ],
            [
                'type' => 'back', // set print file placement on item. If not set, default placement for this product will be used
                'id' => 1, // file id from my File library in Printful (https://www.printful.com/docs/files)
            ],
        ]
    ]);

    $updatedVariant = $productsApi->updateVariant($variantId, $variantRequest);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}