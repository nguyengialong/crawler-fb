<?php


namespace App\FacebookSDK;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FacebookClient
{
    /**
     * @const string Production Graph API URL.
     */
    const BASE_GRAPH_URL = 'https://graph.facebook.com';
    
    /**
     * @const string Graph API URL for video uploads.
     */
//    const BASE_GRAPH_VIDEO_URL = 'https://graph-video.facebook.com';
    
    /**
     * @const int The timeout in seconds for a normal request.
     */
    const DEFAULT_REQUEST_TIMEOUT = 60;
    
    /**
     * @var Client The Guzzle client.
     */
    protected $guzzleClient;
    
    /**
     * @param Client|null $guzzleClient
     */
    public function __construct( Client $guzzleClient = null ) {
        $this->guzzleClient = $guzzleClient ?: new Client();
    }
    
    public function request( $method, $endpoint, array $params, $access_token, $graph_version) {
        if (empty($access_token)) {
            throw new \Exception("You must provide an access token.");
        }
        $url = $this->createUrl($endpoint, $graph_version);
        $timeout = self::DEFAULT_REQUEST_TIMEOUT;
        try {
            $rawResponse = $this->guzzleClient->request($method, $url,[
                "timeout" => $timeout,
                "query" => array_merge($params,[
                    'access_token' => $access_token
                ])
            ]);
            
            return new FacebookResponse(
                $rawResponse->getBody(),
                $rawResponse->getStatusCode(),
                $rawResponse->getHeaders()
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    
    private function createUrl($endpoint, $graph_version) {
        
        return self::BASE_GRAPH_URL."/$graph_version/".$endpoint;
    }
    
}