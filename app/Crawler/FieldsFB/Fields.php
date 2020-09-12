<?php


namespace App\Crawler\FieldsFB;


/**
 * @property array  options
 */
class Fields implements FieldInterface
{
    protected $options = [];

    public function __construct($options = []) {
        if (!empty($options)) {
            $this->options = $options;
        }
    }

    public function getOptions() :array {
        return $this->options;
    }

    public function getOptionsStr() :string {
        return implode($this->getOptions(), ',');
    }
}