<?php

namespace Printful\Tests;

use Printful\PrintfulApiClient;
use Printful\PrintfulMockupGenerator;

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
     * @return PrintfulMockupGenerator
     */
    protected function generator()
    {
        return new PrintfulMockupGenerator($this->api);
    }

    /**
     * @param int $width
     * @param int $height
     * @return string
     */
    protected function getDummyImageUrl($width, $height)
    {
        // return 'http://lorempixel.com/' . $width . '/' . $height;
        return 'https://dummyimage.com/' . $width . 'x' . $height . '/000/fff';
    }
}