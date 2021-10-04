<?php
namespace Jankx\Filter;

use Jankx\Filter\BuiltInFeatures;
use Jankx\Filter\Interfaces\FilterInterface;
use Jankx\Filter\Filters\SimpleFilter;
use Jankx\Filter\FilterData;

class FilterOptions
{
    private $builtInFeatures;

    protected $name;
    protected $filterType;
    protected $displayType;
    protected $datas = array();

    public function __construct($builtInFeatures = null)
    {
        if (is_null($builtInFeatures)) {
            $this->builtInFeatures = BuiltInFeatures::getInstance();
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setFilterType($filterType)
    {
        $filters = $this->builtInFeatures->getFilters();
        if (isset($filters[$filterType])) {
            $filterCls = array_get($filters[$filterType], 'filter_class', SimpleFilter::class);
            if (!class_exists($filterCls) || !is_a($filterCls, FilterInterface::class, true)) {
                error_log(sprintf("Class filter \"%s\" is not valid", $filterCls));
                return;
            }
            $this->filterType = new $filterCls();
        }
    }

    public function getFilterType()
    {
        return $this->filterType;
    }

    public function setDisplayType($displayType)
    {
        $this->displayType = $displayType;
    }

    public function getDisplayType()
    {
        return $this->displayType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDatas($datas)
    {
        if (is_a($datas, FilterData::class)) {
            $this->datas = $datas;
        }
    }
}
