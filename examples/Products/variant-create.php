<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\Exceptions\PrintfulSdkException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate how to create Variant using Products Api
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#actionCreateVariant
 */

// Replace this with your API key
$apiKey = '';

// Example A
try {

    // product id in your Printful store to which variant will be added
    $productId = 1;

    // you can also use your external id
    // $externalId = 32142;
    // $productId = '@'.$externalId;

    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    $variantRequest = SyncVariantRequest::fromArray([
        'external_id' => 1, // set id in my store for this variant (optional)
        'retail_price' => 21.00, // set retail price that this item is sold for (optional)
        'variant_id' => 4011, // set variant in from Printful Catalog(https://www.printful.com/docs/catalog)
        'files' => [
            [
                'url' => 'https://www.my-webshop.com/shirt.jpg',
            ],
            [
                'type' => 'back', // set print file placement on item. If not set, default placement for this product will be used
                'url' => 'https://www.my-webshop.com/shirt.jpg',
            ],
        ],
        'options' => [
            [
                'id' => 'embroidery_type',
                'value' => 'flat',
            ],
        ],
    ]);

    $variant = $productsApi->createVariant($productId, $variantRequest);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
