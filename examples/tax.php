<?php
/**
 * Created by Onur Degerli.
 * User: printful
 * Date: 2019-03-20
 * Time: 17:37
 */

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

$pf = new PrintfulApiClient(getenv('API_KEY'));

try {
    // Retrive country list
    $taxes = $pf->get('tax/countries');
    var_export($taxes);
exit;
} catch (PrintfulApiException $e) { //API response status code was not successful
    echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
} catch (PrintfulException $e) { //API call failed
    echo 'Printful Exception: ' . $e->getMessage();
    var_export($pf->getLastResponseRaw());
}
