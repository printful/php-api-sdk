<?php

namespace Printful\Tests\ApiClient;

use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;
use Printful\Tests\Credentials;
use Printful\Tests\TestCase;

class PrintfulApiClientTest extends TestCase
{

    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function testGet_withApiKey_returnsWithNoAuthErrors()
    {
        $sut = PrintfulApiClient::createLegacyStoreKeyClient(Credentials::$apiKey);

        $this->overrideUrl($sut);

        $result = $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);

        self::assertNotNull($result);
    }

    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function testGet_withOauthToken_returnsWithNoAuthErrors()
    {
        $sut = PrintfulApiClient::createOauthClient(Credentials::$oAuthToken);

        $this->overrideUrl($sut);

        $result = $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);
        self::assertNotNull($result);
    }

    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function testGet_withInvalidCredentials_throwsApiException()
    {
        $sut = PrintfulApiClient::createOauthClient('invalid key');

        $this->overrideUrl($sut);

        $this->expectException(PrintfulException::class);
        $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);
    }

    private function overrideUrl(PrintfulApiClient $sut)
    {
        if (Credentials::$apiUrlOverride) {
            $sut->url = Credentials::$apiUrlOverride;
        }
    }
}