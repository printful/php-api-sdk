<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\Exceptions\PrintfulSdkException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\SyncProductCreationParameters;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate usage of Products API using data in an array
 * Docs for this endpoint can be found here: https://www.printful.com/docs/products#actionCreateProduct
 */

// Replace this with your API key
$apiKey = '';

try {
    // create ApiClient
    $pf = new PrintfulApiClient($apiKey);

    // create Products Api object
    $productsApi = new PrintfulProducts($pf);

    $data = [
        'sync_product' => [
            'external_id' => 1, // set id in my store for this product (optional)
            'name' => 'My new shirt',
            'thumbnail' => 'https://www.my-webshop.com/shirt.jpg', // set thumbnail url
        ],
        'sync_variants' => [ // add sync variants
            [
                'external_id' => 1, // set id in my store for this variant (optional)
                'retail_price' => 21.00, // set retail price that this item is sold for (optional)
                'variant_id' => 4011, // set variant in from Printful Catalog(https://www.printful.com/docs/catalog)
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
            ],
            [
                'external_id' => 2, // set id in my store for this variant (optional)
                'retail_price' => 21.00, // set retail price that this item is sold for (optional)
                'variant_id' => 4012, // set variant in from Printful Catalog(https://www.printful.com/docs/catalog)
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
            ],

        ],
    ];

    $creationParams = SyncProductCreationParameters::fromArray($data);

    $product = $productsApi->createProduct($creationParams);

} catch (PrintfulApiException $e) { // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulSdkException $e) { // SDK did not call API
    echo 'Printful SDK Exception: ' . $e->getMessage();
} catch (PrintfulException $e) { // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}