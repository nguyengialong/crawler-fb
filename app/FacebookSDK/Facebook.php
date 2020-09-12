<?php


namespace App\FacebookSDK;




use App\FacebookSDK\Helper\UrlDetection;

class Facebook
{
    const VERSION = "0.1";
    
    /**
     * @var String The Graph API version for requests.
     */
    protected $graph_version;
    
    /**
     * @var FacebookClient The Facebook client service.
     */
    protected $client;
    
    /**
     * @var UrlDetection The URL detection handler.
     */
    protected $url_detection;
    
    /**
     * @var String The access token to use with requests
     */
    protected $token;
    
    /**
     * @var array The config for Facebook SDK
     */
    protected $config;
    
    public function __construct( array $config = []) {
        $this->config = array_merge([], $config);
        
        $this->setGraphVersion( $this->config['graph_version'] ?? config('facebook_sdk.graph_version') );
        $this->setAccessToken($this->config['access_token'] ?? config('facebook_sdk.default_access_token'));
        
        $this->client = new FacebookClient();
        $this->url_detection = new UrlDetection();
    }
    
    public function setGraphVersion( string $version ) :Facebook {
        $this->graph_version = $version;
        
        return $this;
    }
    
    public function setAccessToken( ?string $token ) {
        $this->token = $token;
    }
    
    /**
     * Returns the FacebookClient service.
     *
     * @return FacebookClient
     */
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * Sends a request to Graph and returns the result.
     *
     * @param string $method
     * @param string $endpoint
     * @param null $access_token
     * @param array $params
     * @param null $graph_version
     * @return FacebookResponse
     * @throws \Exception
     */
    public function request($method, $endpoint, array $params = [], $access_token = null, $graph_version = null)
    {
        $access_token = $access_token ?: $this->token;
        $graph_version = $graph_version ?: $this->graph_version;
        
        return $this->client->request($method, $endpoint, $params, $access_token, $graph_version);
    }
    
    /**
     * Sends a get request to Graph and returns the result.
     *
     * @param $endpoint
     * @param null $access_token
     * @param array $params
     * @param null $graph_version
     * @return FacebookResponse
     * @throws \Exception
     */
    public function get($endpoint, array $params = [], $access_token = null, $graph_version = null)
    {
        return $this->request(
            'GET',
            $endpoint,
            $params,
            $access_token,
            $graph_version
        );
    }
    
    
}