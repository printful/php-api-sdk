<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\Exceptions\PrintfulSdkException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;
use Printful\Structures\Sync\SyncProductCreationParameters;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate usage of Products API in mixed fashion
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#actionCreateProduct
 */

// Replace this with your API key
$apiKey = '';

try {
    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    // create product request
    $productRequest = SyncProductRequest::fromArray([
        'external_id' => 1, // set id in my store for this product (optional)
        'name' => 'My new shirt', // set product name
        'thumbnail' => 'https://www.my-webshop.com/shirt.jpg', // // set thumbnail url (optional)
    ]);

    // create creationParams
    $creationParams = new SyncProductCreationParameters($productRequest);

    // create variant A (Bella + Canvas 3001, S, White)
    $syncVariantRequest = SyncVariantRequest::fromArray([
        'external_id' => 1, // set id in my store for this variant (optional)
        'variant_id' => 4011, // set variant in from Printful Catalog(https://www.printful.com/docs/catalog)
        'retail_price' => 21.00, // set retail price that this item is sold for (optional)
        'files' => [
            [
                'url' => 'https://www.my-webshop.com/shirt.jpg',
            ],
            [
                'type' => 'back', // set print file placement on item. If not set, default placement for this product will be used
                'id' => 1, // file id from my File library in Printful (https://www.printful.com/docs/files)
            ],
        ],
        'options' => [
            [
                'id' => 'embroidery_type',
                'value' => 'flat'
            ],
        ],
    ]);

    // add variant to creation params
    $creationParams->addSyncVariant($syncVariantRequest);

    // create variant B (Bella + Canvas 3001, M, White)
    $syncVariantRequest = SyncVariantRequest::fromArray([
        'external_id' => 2, // set id in my store for this variant (optional)
        'variant_id' => 4012, // set variant in from Printful Catalog(https://www.printful.com/docs/catalog)
        'retail_price' => 21.00, // set retail price that this item is sold for (optional)
        'files' => [
            [
                'url' => 'https://www.my-webshop.com/shirt.jpg',
            ],
            [
                'type' => 'back', // set print file placement on item. If not set, default placement for this product will be used
                'id' => 1, // file id from my File library in Printful (https://www.printful.com/docs/files)
            ],
        ],
        'options' => [
            [
                'id' => 'embroidery_type',
                'value' => 'flat'
            ],
        ],
    ]);

    // add variant to creation params
    $creationParams->addSyncVariant($syncVariantRequest);

    $product = $productsApi->createProduct($creationParams);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}