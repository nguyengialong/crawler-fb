<?php


namespace App\Crawler\FieldsFB;


class AttachmentField extends Fields
{

    protected $options = [
        'media',
        'target',
        'subattachments.limit(40)'
    ];
}
