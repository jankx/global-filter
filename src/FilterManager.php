<?php
namespace Jankx\Filter;

use Jankx\Filter\Filters\SimpleFilter;

class FilterManager
{
    protected $filterStyles;
    protected static $instance;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->filterStyles = array(
            'simple' => new SimpleFilter(),
        );
    }

    public function getFilterStyles($refresh = true)
    {
        return apply_filters(
            'jankx/filter/global/styles',
            $this->filterStyles
        );
    }

    public function getFilterStyle($filterName)
    {
        $styles = $this->getFilterStyles(false);
        if (isset($styles[$filterName])) {
            return $styles[$filterName];
        }
    }
}
