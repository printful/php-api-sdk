<?php

declare(strict_types=1);

namespace Printful\Tests\ApiClient;


use Printful\PrintfulApiClient;
use Printful\Tests\Credentials;
use Printful\Tests\TestCase;

class PrintfulApiClientTest extends TestCase
{
    /**
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulApiException
     */
    public function testGet_withApiKey_returnsWithNoAuthErrors(): void
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
    public function testGet_withOauthToken_returnsWithNoAuthErrors(): void
    {
        $sut = new PrintfulApiClient(Credentials::$apiKey);

        $sut->setOauthToken(Credentials::$oAuthToken);

        $this->overrideUrl($sut);

        $sut->get('orders', [
            'offset' => 0,
            'limit' => 10,
            'status' => null,
        ]);
    }

    private function overrideUrl(PrintfulApiClient $sut): void
    {
        if (Credentials::$apiUrlOverride) {
            $sut->url = Credentials::$apiUrlOverride;
        }
    }
}