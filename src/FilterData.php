<?php
namespace Jankx\Filter;

use Jankx\Filter\FilterOption;
use Jankx\Filter\Abstracts\Data;

class FilterData extends Data
{
    protected $options = array();
    protected $displayType;
    protected $typeName;

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

    public function setDisplayType($displayType)
    {
        $this->displayType = $displayType;
    }

    public function getDisplayType()
    {
        return $this->displayType;
    }

    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
    }

    public function getFirstOption() {
        if (count($this->options)) {
            return $this->options[0];
        }
    }
}
