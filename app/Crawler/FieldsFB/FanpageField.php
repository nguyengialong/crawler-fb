<?php


namespace App\Crawler\FieldsFB;


class FanpageField extends Fields
{

    protected $options = [
        'id',
//        'link',
        'permalink_url',
//        'type',
        'created_time',
        'message',
        'attachments{media,media_type,type,target,subattachments.limit(40)}',
        'likes.limit(0).summary(true)',
        'comments.limit(200){id,created_time,from,message,message_tags,attachment,comments.limit(100){id,created_time,from,message,message_tags,attachment}}'
    ];
}
