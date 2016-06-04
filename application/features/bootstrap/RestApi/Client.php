<?php

/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RestApi;

/**
 * Class Client
 *
 * @package RestApi
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class Client
{
    const HTTP_OK = 200;

    /**
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $apiBaseUrl;
    private $apiUser;
    private $apiPassword;

    /**
     * Client constructor.
     *
     * @param string $apiBaseUrl
     * @param string $apiUser
     * @param string $apiPassword
     */
    public function __construct($apiBaseUrl, $apiUser, $apiPassword)
    {
        $this->apiBaseUrl = $apiBaseUrl;
        $this->apiUser = $apiUser;
        $this->apiPassword = $apiPassword;
    }

    /**
     * Send a HTTP GET request to get the state of the given resource
     * 
     * @param string $resourcePath
     * 
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    public function get($resourcePath)
    {
        if (($response = $this->getHttpClient()->get($resourcePath, $this->getOptions())) && $response->getStatusCode() == self::HTTP_OK) {
            return $response->getBody();
        }
        
        throw new \RuntimeException(
            sprintf(
                'HTTP GET request to "%s" responded with an error code %d.', 
                $resourcePath, 
                $response->getStatusCode()
            )
        );
    }

    private function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new \GuzzleHttp\Client(['base_uri' => $this->apiBaseUrl]);
        }
        return $this->httpClient;
    }

    private function getOptions()
    {
        return ['auth' => [$this->apiUser, $this->apiPassword]];
    }
}