<?php


namespace App\Crawler\FieldsFB;


class GroupField extends Fields
{

    public $options = [
        'id',
        'link',
        'permalink_url',
        'name',
        'from',
        'created_time',
        'message',
        'attachments{media,media_type,type,target,subattachments.limit(40)}',
//        'type',
        'likes.limit(0).summary(true)',
        'comments.limit(200){id,created_time,from,message,message_tags,attachment,comments.limit(100){id,created_time,from,message,message_tags,attachment}}'
    ];
}
