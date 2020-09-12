<?php


namespace App\Crawler\FieldsFB;


class CommentField extends Fields
{

    protected $options = [
        'id',
        'created_time',
        'from',
        'message',
        'message_tags',
        'attachment',
        'likes.limit(0).summary(true)',
        'comments.limit(100){id,created_time,from,message,message_tags,attachment}'
    ];
}
