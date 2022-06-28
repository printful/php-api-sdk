<?php

namespace Printful;

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;

/**
 * Class PrintfulClient
 */
class PrintfulApiClient
{
    const TYPE_LEGACY_STORE_KEY = 'legacy-store-key';
    const TYPE_OAUTH_TOKEN = 'oauth-token';
    const DEFAULT_KEY = self::TYPE_LEGACY_STORE_KEY;

    /**
     * Printful API key
     * @var string|null
     */
    private $legacyStoreKey;

    /**
     * Printful OAuth token
     * @var string|null
     */
    private $oauthToken;

    private $lastResponseRaw;

    private $lastResponse;

    public $url = 'https://api.printful.com/';

    const USER_AGENT = 'Printful PHP API SDK 2.0';

    /**
     * Maximum amount of time in seconds that is allowed to make the connection to the API server
     * @var int
     */
    public $curlConnectTimeout = 20;

    /**
     * Maximum amount of time in seconds to which the execution of cURL call will be limited
     * @var int
     */
    public $curlTimeout = 20;

    /**
     * @param string $key
     * @param string $type // PrintfulApiClient::TYPE_LEGACY_STORE_KEY or PrintfulApiClient::TYPE_OAUTH_TOKEN
     * @throws \Printful\Exceptions\PrintfulException if the library failed to initialize
     */
    public function __construct($key, $type = self::DEFAULT_KEY)
    {
        if ($type === self::TYPE_LEGACY_STORE_KEY && strlen($key) < 32) {
            throw new PrintfulException('Invalid Printful store key!');
        }

        $this->legacyStoreKey = $type === self::TYPE_LEGACY_STORE_KEY ? $key : null;
        $this->oauthToken = $type === self::TYPE_OAUTH_TOKEN ? $key : null;
    }

    /**
     * @param string $oAuthToken
     * @throws PrintfulException
     */
    public static function createOauthClient($oAuthToken)
    {
        return new self($oAuthToken, self::TYPE_OAUTH_TOKEN);
    }

    /**
     * @param string $legacyStoreKey
     * @throws PrintfulException
     */
    public static function createLegacyStoreKeyClient($legacyStoreKey)
    {
        return new self($legacyStoreKey, self::TYPE_LEGACY_STORE_KEY);
    }

    /**
     * Returns total available item count from the last request if it supports paging (e.g order list) or null otherwise.
     *
     * @return int|null Item count
     */
    public function getItemCount()
    {
        return isset($this->lastResponse['paging']['total']) ? $this->lastResponse['paging']['total'] : null;
    }

    /**
     * Perform a GET request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @param array $params Additional GET parameters as an associative array
     * @return mixed API response
     * @throws \Printful\Exceptions\PrintfulApiException if the API call status code is not in the 2xx range
     * @throws PrintfulException if the API call has failed or the response is invalid
     */
    public function get($path, $params = [])
    {
        return $this->request('GET', $path, $params);
    }

    /**
     * Perform a DELETE request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @param array $params Additional GET parameters as an associative array
     * @return mixed API response
     * @throws \Printful\Exceptions\PrintfulApiException if the API call status code is not in the 2xx range
     * @throws \Printful\Exceptions\PrintfulException if the API call has failed or the response is invalid
     */
    public function delete($path, $params = [])
    {
        return $this->request('DELETE', $path, $params);
    }

    /**
     * Perform a POST request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @param array $data Request body data as an associative array
     * @param array $params Additional GET parameters as an associative array
     * @return mixed API response
     * @throws \Printful\Exceptions\PrintfulApiException if the API call status code is not in the 2xx range
     * @throws PrintfulException if the API call has failed or the response is invalid
     */
    public function post($path, $data = [], $params = [])
    {
        return $this->request('POST', $path, $params, $data);
    }

    /**
     * Perform a PUT request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @param array $data Request body data as an associative array
     * @param array $params Additional GET parameters as an associative array
     * @return mixed API response
     * @throws \Printful\Exceptions\PrintfulApiException if the API call status code is not in the 2xx range
     * @throws \Printful\Exceptions\PrintfulException if the API call has failed or the response is invalid
     */
    public function put($path, $data = [], $params = [])
    {
        return $this->request('PUT', $path, $params, $data);
    }

    /**
     * Return raw response data from the last request
     * @return string|null Response data
     */
    public function getLastResponseRaw()
    {
        return $this->lastResponseRaw;
    }

    /**
     * Return decoded response data from the last request
     * @return array|null Response data
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Internal request implementation
     * @param string $method POST, GET, etc.
     * @param string $path
     * @param array $params
     * @param mixed $data
     * @return
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     */
    private function request($method, $path, array $params = [], $data = null)
    {
        $this->lastResponseRaw = null;
        $this->lastResponse = null;

        $url = trim($path, '/');

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $curl = curl_init($this->url . $url);

        $this->setCredentials($curl);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->curlConnectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->curlTimeout);

        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);

        if ($data !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $this->lastResponseRaw = curl_exec($curl);

        $errorNumber = curl_errno($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($errorNumber) {
            throw new PrintfulException('CURL: ' . $error, $errorNumber);
        }

        $this->lastResponse = $response = json_decode($this->lastResponseRaw, true);

        if (!isset($response['code'], $response['result'])) {
            $e = new PrintfulException('Invalid API response');
            $e->rawResponse = $this->lastResponseRaw;
            throw $e;
        }
        $status = (int)$response['code'];
        if ($status < 200 || $status >= 300) {
            $e = new PrintfulApiException((string)$response['result'], $status);
            $e->rawResponse = $this->lastResponseRaw;
            throw $e;
        }
        return $response['result'];
    }

    /**
     * @param resource $curl
     * @throws PrintfulException
     */
    private function setCredentials($curl)
    {
        if ($this->oauthToken !== null) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer $this->oauthToken"]);
        } elseif ($this->legacyStoreKey !== null) {
            curl_setopt($curl, CURLOPT_USERPWD, $this->legacyStoreKey);
        } else {
            throw new PrintfulException('Either OAuth token or store key must be set to make this request.');
        }
    }
}