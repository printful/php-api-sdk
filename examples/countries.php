<?php

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

require_once __DIR__ . '/config.php';

$pf = new PrintfulApiClient(getenv('API_KEY'));

try {
    // Retrieve country list
    $countries = $pf->get('countries');
    var_export($countries);
} catch (PrintfulApiException $e) { //API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { //API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
