<?php

namespace Printful\Tests;

use Printful\PrintfulApiClient;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var \Printful\PrintfulApiClient */
    protected $apiClient;

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists(Credentials::class)) {
            throw new \Exception('Printful test credentials are not set. Copy "tests/Credentials.php.dist" to "tests/Credentials.php and enter the API key');
        }

        $this->apiClient = new PrintfulApiClient(Credentials::$apiKey);
    }
}