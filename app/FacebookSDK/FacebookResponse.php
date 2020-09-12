<?php


namespace App\FacebookSDK;


use App\FacebookSDK\GraphNode\GraphNode;
use Barryvdh\Reflection\DocBlock\Type\Collection;

class FacebookResponse
{
    protected $status_code;
    
    protected $headers;
    
    protected $body;
    
    /**
     * @var Collection graph node
     */
    protected $graph_nodes;
    
    protected $paging;
    
    public function __construct( $body = null, $status_code = 200, array $headers = [], $graph_node = true ) {
        $this->status_code = $status_code;
        $this->headers = $headers;
        
        $this->body = \GuzzleHttp\json_decode( $body );
        if ($graph_node) {
            try {
                $this->setGraphNodes();
            } catch (\Exception $exception) {
                throw new \Exception("Can't create graph node: " . $exception->getMessage());
            }
        }
        $this->paging = $this->body->paging ?? null;
    }
    
    
    
    protected function setGraphNodes() {
        $graph_nodes = [];
        foreach ($this->getRawData() as $item) {
            $graph_nodes[] = new GraphNode((array)$item);
        }
        $this->graph_nodes = collect($graph_nodes);
    }
    
    public function getGraphNodes() {
        return $this->graph_nodes;
    }
    
    public function getHeaders() {
        return $this->headers;
    }
    
    public function getStatusCode() {
        return $this->status_code;
    }
    
    public function getBody() {
        return $this->body;
    }
    
    public function getRawData() {
        return $this->body->data;
    }
    
    public function getPaging() {
        return $this->paging;
    }
    
    
}