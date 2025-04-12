<?php

namespace Jankx\Filter\Filters;

use Jankx\Filter\Abstracts\Filter;
use Jankx\Filter\FilterTemplate;

class TaxonomyFilter extends Filter
{
    const FILTER_NAME = 'taxonomy-filter';
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
        $data = $this->getData();
        if (is_null($data)) {
            return;
        }

        return FilterTemplate::loadTemplate(
            'taxonomy-filter',
            array(
                'filter_options' => $data->getOptions(),
                'data_type' => $data->getId(),
                'filter_type' => $this->getName(),
                'filter' => $this,
                'support_multiple' => apply_filters('jankx/global-filters/taxonomy-filter/enabled', false),
            )
        );
    }

    public function renderChildOptions($childOptions, $dataType)
    {
        return FilterTemplate::loadTemplate(
            'taxonomy-filter',
            array(
                'filter_options' => $childOptions,
                'data_type' => $dataType,
                'filter_type' => $this->getName(),
                'filter' => $this,
                'support_multiple' => apply_filters('jankx/global-filters/taxonomy-filter/enabled', false),
            )
        );
    }
}
