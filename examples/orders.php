<?php
use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

require_once __DIR__ . '../vendor/autoload.php';

// Replace this with your API key
$apiKey = '';

$pf = new PrintfulApiClient($apiKey);

try {

    // -------------------------------
    // Select 10 latest orders
    /*
    $orders = $pf->get('orders', ['limit' => 10]);
    var_export($orders);
    // Get total number of items available from the previous request
    $items = $pf->getItemCount();
    echo "Total orders " . $items;
    */
    // -------------------------------


    // -------------------------------
    // Select order with ID 12345 (Replace with your order's ID)
    /*
    $order = $pf->get('orders/12345');
    var_export($order);
    */
    // -------------------------------


    // -------------------------------
    // Select order with External ID 9900999 (Replace with your order's External ID)
    /*
    $order = $pf->get('orders/@9900999');
    var_export($order);
    */
    // -------------------------------


    // -------------------------------
    // Confirm order with ID 12345 (Replace with your order's ID)
    /*
    $order = $pf->post('orders/12345/confirm');
    var_export($order);
    */
    // -------------------------------


    // -------------------------------
    // Cancel order with ID 12345 (Replace with your order's ID)
    /*
    $order = $pf->delete('orders/12345');
    var_export($order);
    */
    // -------------------------------


    // -------------------------------
    // Create an order
    /*
    $order = $pf->post('orders', [
        'recipient' => [
            'name' => 'John Doe',
            'address1' => '172 W Street Ave #105',
            'city' => 'Burbank',
            'state_code' => 'CA',
            'country_code' => 'US',
            'zip' => '91502',
        ],
        'items' => [
            [
                'variant_id' => 1,//Small poster
                'name' => 'Niagara Falls poster', //Display name
                'retail_price' => '19.99', //Retail price for packing slip
                'quantity' => 1,
                'files' => [
                    [
                        'url' => 'http://example.com/files/posters/poster_1.jpg',
                    ],
                ],
            ],
            [
                'variant_id' => 1118,
                'quantity' => 2,
                'name' => 'Grand Canyon T-Shirt', //Display name
                'retail_price' => '29.99', //Retail price for packing slip
                'files' => [
                    [// Front print
                        'url' => 'http://example.com/files/tshirts/shirt_front.ai',
                    ],
                    [// Back print
                        'type' => 'back',
                        'url' => 'http://example.com/files/tshirts/shirt_back.ai',
                    ],
                    [// Mockup image
                        'type' => 'preview',
                        'url' => 'http://example.com/files/tshirts/shirt_mockup.jpg',
                    ],
                ],
                'options' => [// Additional options
                    [
                        'id' => 'remove_labels',
                        'value' => true,
                    ],
                ],
            ],
        ],
    ]);
    var_export($order);
    */
    // -------------------------------

    // -------------------------------
    // Create an order and confirm immediately
    /*
     $order = $pf->post('orders',
        [
            'recipient' => [
                'name' => 'John Doe',
                'address1' => '172 W Street Ave #105',
                'city' => 'Burbank',
                'state_code' => 'CA',
                'country_code' => 'US',
                'zip' => '91502',
            ],
            'items' => [
                [
                    'variant_id' => 1,// Small poster
                    'name' => 'Niagara Falls poster', // Display name
                    'retail_price' => '19.99', // Retail price for packing slip
                    'quantity' => 1,
                    'files' => [
                        [
                            'url' => 'http://example.com/files/posters/poster_1.jpg',
                        ],
                    ],
                ],
            ],
        ],
        ['confirm' => 1]
    );
    var_export($order);
    */
    // -------------------------------

} catch (PrintfulApiException $e) {
    // API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) {
    // API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
