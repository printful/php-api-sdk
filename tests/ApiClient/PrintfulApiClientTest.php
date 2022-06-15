<?php

declare(strict_types=1);

namespace Printful\Tests\ApiClient;


use Printful\PrintfulApiClient;
use Printful\Tests\Credentials;
use Printful\Tests\TestCase;

class PrintfulApiClientTest extends TestCase
{
    /**
     * @dataProvider credentialProvider
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testGet_returnsWithNoAuthErrors($key): void
    {
        $sut = new PrintfulApiClient($key);
        $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);
    }

    public function credentialProvider(): iterable
    {
        yield 'Basic Api Key' => [
            Credentials::$apiKey
        ];

        yield 'Bearer OAuth Token' => [
            Credentials::$oAuthToken
        ];
    }
}