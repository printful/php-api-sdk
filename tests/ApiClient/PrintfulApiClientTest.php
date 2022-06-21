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
        $sut = new PrintfulApiClient(Credentials::$apiKey);

        $this->overrideUrl($sut);

        $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);
    }

    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function testGet_withOauthToken_returnsWithNoAuthErrors()
    {
        $sut = new PrintfulApiClient(null, Credentials::$oAuthToken);

        $this->overrideUrl($sut);

        $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);
    }

    public function testConstruct_withNoCredentials_throwsException()
    {
        $this->expectException(PrintfulException::class);
        new PrintfulApiClient();
    }

    private function overrideUrl(PrintfulApiClient $sut)
    {
        if (Credentials::$apiUrlOverride) {
            $sut->url = Credentials::$apiUrlOverride;
        }
    }
}
