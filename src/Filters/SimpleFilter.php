<?php

namespace Jankx\Filter\Filters;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

use Jankx\Filter\Abstracts\Filter;
use Jankx\Filter\FilterData;

class SimpleFilter extends Filter
{
    const FILTER_NAME = 'simple-filter';

    public function getName()
    {
        return static::FILTER_NAME;
    }

    public function getTitle()
    {
        return __('Simple Filter', 'jankx_filter');
    }

    public function renderSelectFilter($filterData)
    {
        $selectFilterWrap = array(
            'class' => array('jankx-filter-wrap', sprintf('%s-%s', $filterData->getDataType(), $filterData->getId()))
        );
        echo sprintf('<div %s>', jankx_generate_html_attributes($selectFilterWrap));
            $selectTagAttributes = array(
                'class' => array('select-filter', sprintf('%s-data', $filterData->getDataType())),
                'name' => $filterData->getId(),
                'data-object-type' => $filterData->getDataType()
            );
            echo sprintf('<select %s>', jankx_generate_html_attributes($selectTagAttributes));
                echo '<option value="">' . $filterData->getName() . '</option>';
            foreach ($filterData->getOptions() as $filterOption) {
                $optionAttributes = array(
                    'value' => $filterOption->getId(),
                );
                echo sprintf('<option %1$s>%2$s</option>', jankx_generate_html_attributes($optionAttributes), $filterOption->getName());
            }
            echo '</select>';
            echo '</div>';
    }

    public function renderFilterData($filterData)
    {
        switch ($filterData->getDisplayType()) {
            case 'select':
            case 'choices':
            case null:
                return $this->renderSelectFilter($filterData);
        }
    }

    public function render()
    {
        $filterStyleWrap = array(
            'class' => 'simple-filter-wrapper filter-form',
            'action' => '',
            'method' => 'GET'
        );
        echo sprintf('<form %s>', jankx_generate_html_attributes($filterStyleWrap));
        if (!is_a($this->data, FilterData::class)) {
            return;
        }

            $this->renderFilterData($this->data);
            $this->afterFormContent();

        echo '</form>';
    }

    protected function afterFormContent()
    {
        echo sprintf(
            '<div class="jankx-filter-wrap submit-form">
                <button type="submit">%s</button>
            </div>',
            apply_filters(
                'jankx/filter/simple/submit/text',
                __('Search', 'jankx_filter')
            )
        );
    }
}
