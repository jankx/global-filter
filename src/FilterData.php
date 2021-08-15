<?php
namespace Jankx\Filter;

use Jankx\Filter\FilterOption;
use Jankx\Filter\Abstracts\Data;

class FilterData extends Data
{
    protected $options = array();

    public function addOption($filterOption)
    {
        if (!is_a($filterOption, FilterOption::class)) {
            return;
        }
        array_push($this->options, $filterOption);
    }

    public function getOptions()
    {
        return $this->options;
    }
}
