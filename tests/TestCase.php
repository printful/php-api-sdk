<?php

namespace Printful\Tests;

use Printful\MockupGenerator;
use Printful\PrintfulApiClient;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var PrintfulApiClient */
    protected $api;

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists(Credentials::class)) {
            throw new \Exception('Printful test credentials are not set. Copy "tests/Credentials.php.dist" to "tests/Credentials.php and enter the API key');
        }

        $this->api = new PrintfulApiClient(Credentials::$apiKey);

        // Override API URL if is set
        if (Credentials::$apiUrlOverride) {
            $this->api->url = Credentials::$apiUrlOverride;
        }
    }

    /**
     * @return MockupGenerator
     */
    protected function generator()
    {
        return new MockupGenerator($this->api);
    }
}