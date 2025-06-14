<?php

namespace Jankx\Filter\Filters;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

use Jankx\Filter\FilterTemplate;
use Jankx\Filter\Abstracts\Filter;

class MultiValuesFilter extends Filter
{
    const FILTER_NAME = 'multi-values-filter';

    protected $data;
    protected $options;

    public function getName()
    {
        return static::FILTER_NAME;
    }

    public function getTitle()
    {
        return __('Multi Values', 'jankx_filter');
    }

    public function render()
    {
        $data = $this->getData();
        if (is_null($data)) {
            return;
        }

        $options = $this->getOptions();

        return FilterTemplate::loadTemplate(
            'multi-values-filter',
            array(
                'filter_options' => $data->getOptions(),
                'data_type' => $data->getId(),
                'options' => $options,
                'filter_type' => $this->getName(),
            )
        );
    }
}
