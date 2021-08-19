<?php
namespace Jankx\Filter\Filters;

use Jankx\Filter\Abstracts\Filter;
use Jankx\Filter\FilterData;

class SimpleFilter extends Filter
{
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
        foreach ($this->data as $filterData) {
            if (!is_a($filterData, FilterData::class)) {
                continue;
            }
            $this->renderFilterData($filterData);
        }

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
