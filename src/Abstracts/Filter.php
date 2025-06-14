<?php

namespace Jankx\Filter\Abstracts;

if (!defined('ABSPATH')) {
    exit('Cheatin huh?');
}

use Jankx;
use Jankx\Filter\FilterData;
use Jankx\Filter\FilterOptions;
use Jankx\Filter\Interfaces\FilterInterface;

abstract class Filter implements FilterInterface
{
    protected $data;
    protected $options;

    public function __construct($data = null)
    {
        if (!is_null($data)) {
            $this->setData($data);
        }
    }

    public function setData($data)
    {
        if (is_a($data, FilterData::class)) {
            $this->data = $data;
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function setOptions($options)
    {
        if (is_a($options, FilterOptions::class)) {
            $this->options = $options;
        }
    }

    public function getOptions()
    {
        return $this->options;
    }

    protected function afterFormContent()
    {
        do_action('jankx/filter/form/content/after');
    }
}
