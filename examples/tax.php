<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

require_once __DIR__ . '/config.php';

$pf = new PrintfulApiClient(getenv('API_KEY'));

try {
    // Retrieve tax list
    $taxes = $pf->get('tax/countries');
    var_export($taxes);
} catch (PrintfulApiException $e) { //API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { //API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
