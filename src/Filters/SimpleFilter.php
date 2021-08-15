<?php
namespace Jankx\Filter\Filters;

use Jankx\Filter\Abstracts\Filter;

class SimpleFilter extends Filter
{
    protected $rules = array();

    public function getTitle()
    {
        return __('Simple Filter', 'jankx_filter');
    }
}
