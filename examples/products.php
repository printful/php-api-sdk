<?php
use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

require_once __DIR__ . '../vendor/autoload.php';

// Replace this with your API key
$apiKey = '';

$pf = new PrintfulApiClient($apiKey);

try {
    // Get information about the store
    /*
    $store = $pf->get('store');
    var_export($store);
    */

    // Get product list
    /*
    $products = $pf->get('products');
    var_export($products);
    */

    // Get variants for product 10
    /*
    $variants = $pf->get('products/10');
    var_export($variants);
    */

    // Get information about Variant 1007
    /*
    $data = $pf->get('products/variant/1007');
    var_export($data);
    */

} catch (PrintfulApiException $e) { //API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { //API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
