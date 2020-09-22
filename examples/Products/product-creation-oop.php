<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\Exceptions\PrintfulSdkException;
use Printful\PrintfulApiClient;
use Printful\PrintfulProducts;
use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequestFile;
use Printful\Structures\Sync\Requests\SyncVariantRequestOption;
use Printful\Structures\Sync\SyncProductCreationParameters;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * This example fill will demonstrate usage of Products API in OOP fashion
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
    $productRequest = new SyncProductRequest;

    // set id in my store for this product (optional)
    $productRequest->externalId = 1;

    // set product name
    $productRequest->name = 'My new shirt';

    // set thumbnail url
    $productRequest->thumbnail = 'https://www.my-webshop.com/shirt.jpg';

    // create creationParams
    $creationParams = new SyncProductCreationParameters($productRequest);

    // create variant
    $syncVariantRequest = new SyncVariantRequest;

    // set id in my store for this variant (optional)
    $syncVariantRequest->externalId = 1;

    // set variant in from Printful Catalog(https://www.printful.com/docs/catalog)
    $syncVariantRequest->variantId = 4011; // Bella + Canvas 3001, S, White

    // set retail price that this item is sold for (optional)
    $syncVariantRequest->retailPrice = 21.00;

    // create print file
    // $file->id or $file->url is required
    $file = new SyncVariantRequestFile();

    // file id from my File library in Printful (https://www.printful.com/docs/files)
    // $file->id = 1;

    // set print file url
    $file->url = 'https://www.my-webshop.com/shirt.jpg';

    // set print file placement on item. If not set, default placement for this product will be used
    $file->type = 'front';

    // add print file to variant. You can add multiple files for single variant (type must be unique)
    $syncVariantRequest->addFile($file);

    // create variant option
    $option = new SyncVariantRequestOption;
    $option->id = 'embroidery_type';
    $option->value = 'flat';

    $syncVariantRequest->addOption($option);

    // add variant to creation params (you can create and add multiple variants)
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