<?php


namespace App\Crawler\FieldsFB;


class SimpleField extends Fields
{

    public $options = [
        'id',
        'permalink_url',
        'name',
        'created_time',
        'message',
        'attachments{subattachments.limit(30)}',
        'type'
    ];
}
