<?php


namespace App\FacebookSDK\GraphNode;


use Carbon\Carbon;

/**
 * @property mixed id
 * @property mixed link
 * @property mixed type
 * @property mixed permalink_url
 * @property mixed created_time
 * @property mixed message
 * @property mixed message_tags
 * @property mixed like
 * @property mixed attachments
 * @property mixed attachment
 * @property mixed comments
 */
class GraphNode
{

    public $original = [];

    protected $attributes = [];

    /**
     * GraphNode constructor.
     * @param $attributes
     */
    public function __construct(array $attributes = []) {
        $this->original = $attributes;
        $this->attributes = $attributes;
        $this->casting();
    }
    
    /**
     * Dynamically retrieve attributes on the node
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name) {
        if (array_key_exists($name, $this->attributes)) {
            return $this->getAttribute($name);
        } else {
            return null;
        }
    }
    
    public function __set($name, $value) {
        return $this->setAttribute($name, $value);
    }

    public function getAttribute($name) {
        return $this->attributes[$name];
    }

    public function setAttribute($name, $value) {
        $this->attributes[$name] = $value;
        return $this;
    }

    protected function casting() {
        $this->castMessage();
        $this->castAttachments();
        $this->castComments();
        $this->castTime();
    }

    protected function castAttachments() {
        if (isset($this->attachments->data[0]->subattachments)) {
            $attachments = $this->attachments->data[0]->subattachments->data;
        } elseif (isset($this->attachments->data)) {
            $attachments = $this->attachments->data;
        } elseif ($this->attachment) {
            $attachments = [$this->attachment];
            unset($this->attributes['attachment']);
        } else {
            $attachments = [];
        }
        $attachments = array_map(function ($attachment) {
            return (object) [
                'id' => $attachment->target->id ?? null,
                'type' => $attachment->type ?? null,
                'url' => $this->link,
                'src' => $attachment->media->image->src ?? null
            ];
        }, $attachments);
        $this->attachments = $attachments;
    }

    protected function castTime() {
        $timestamp = strtotime($this->created_time);

        $time = new Carbon();
        $time->setTimestamp($timestamp);
        $this->created_time = $time;
    }

    protected function castComments() {
        $comments = [];
        $origin_comments = $this->comments;
        if (!empty($origin_comments)) {
            foreach ($origin_comments->data as $comment) {
                $comments[] = new GraphNode(((array)$comment));
            }
        }
        $this->comments = $comments;
    }

    protected function castMessage() {
        if ($this->message_tags) {
            $message = $this->message;
            foreach ($this->message_tags as $tag) {
                $message = str_replace($tag->name, "@[$tag->id]", $message);
            }
            $this->message = $message;
        }
    }
}