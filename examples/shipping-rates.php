<?php
use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

require_once __DIR__ . '../vendor/autoload.php';

// Replace this with your API key
$apiKey = '';

$pf = new PrintfulApiClient($apiKey);

try {
    // Calculate shipping rates for an order
    /*
    $rates = $pf->post('shipping/rates', [
        'recipient' => [
            'country_code' => 'US',
            'state_code' => 'CA',
        ],
        'items' => [
            ['variant_id' => 1, 'quantity' => 1], // Small poster
            ['variant_id' => 1118, 'quantity' => 2] // Alternative T-Shirt
        ],
    ]);
    var_export($rates);
    */

} catch (PrintfulApiException $e) { //API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { //API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
