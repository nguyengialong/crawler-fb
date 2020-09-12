<?php


namespace App\Crawler;


use App\Crawler\FieldsFB\CommentField;
use App\Crawler\FieldsFB\FanpageField;
use App\Crawler\FieldsFB\GroupField;
use App\FacebookSDK\Facebook;
use App\FacebookSDK\Helper\UrlDetection;

class Crawler
{
    const LIMIT = 25;
    /**
     * @var Facebook Facebook SDK
     */
    protected $facebook;
    
    public function __construct() {
        $this->facebook = new Facebook();
    }
    
    public function getFeedOfFanpage($fangage_id, $access_token, $limit = self::LIMIT) {
        $params = [
            'fields' => (new FanpageField())->getOptionsStr(),
            'limit' => $limit,
        ];

        try {
            $response = $this->facebook->get($fangage_id . '/posts', $params, $access_token);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $response->getGraphNodes();
    }
    
    public function getFeedOfGroup($group_id, $access_token, $limit = self::LIMIT) {
        $params = [
            'fields' => (new GroupField())->getOptionsStr(),
            'limit' => $limit,
        ];
    
        try {
            $response = $this->facebook->get($group_id . '/feed', $params, $access_token);
        } catch (\Exception $e) {
            throw new \Exception( $e->getMessage() );
        }

        return $response->getGraphNodes();
    }
    
    public function getAttachments($feed_id, $access_token, $next = false) {
    
    }
    
    public function getImage($image_id) {
    
    }
    
    public function getComment($feed_id, $access_token, $next = false) {
        $params = [
            'fields' => (new GroupField())->getOptionsStr(),
            'limit' => self::LIMIT,
        ];
    
        request_comment:
        try {
            $response = $this->facebook->get($feed_id . '/comments', $params, $access_token);
        } catch (\Exception $e) {
            throw new \Exception( $e->getMessage() );
        }
        foreach ($response->getGraphNodes() as $item) {
            yield $item;
        }
        if ($next && !empty($response->getPaging()->cursors)) {
            $params['after'] =  $response->getPaging()->cursors->after;
            goto request_comment;
        }
    }
}