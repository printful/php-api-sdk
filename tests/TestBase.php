<?php

namespace Printful\Tests;

use Printful\PrintfulApi\PrintfulApiClient;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /** @var PrintfulApiClient */
    protected $apiClient;

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists(PrintfulTestCredentials::class)) {
            throw new \Exception('Printful test credentials are not set. Copy "tests/PrintfulTestCredentials.php.dist" to "tests/PrintfulTestCredentials.php and enter the API key');
        }

        $this->apiClient = new PrintfulApiClient(PrintfulTestCredentials::$apiKey);
    }
}