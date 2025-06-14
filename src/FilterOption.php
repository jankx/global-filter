<?php

namespace Jankx\Filter;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

use Jankx\Filter\Abstracts\Data;

class FilterOption extends Data
{
    protected $childOptions = [];

    public function setChildOptions($filterOptions)
    {
        $this->childOptions = $filterOptions;
    }

    public function getChildOptions()
    {
        if (!is_array($this->childOptions)) {
            return [];
        }

        return $this->childOptions;
    }

    public function hasChildOptions()
    {
        return count($this->childOptions) > 0;
    }
}
