<?php

namespace Jankx\Filter\Filters;

use Jankx\Filter\Abstracts\Filter;

class TaxonomyFilter extends Filter
{
    const FILTER_NAME = 'simple-filter';
    public function getName()
    {
        return static::FILTER_NAME;
    }

    public function getTitle()
    {
        return __('Taxonomy Filter', 'jankx_filter');
    }

    public function render()
    {
    }
}
