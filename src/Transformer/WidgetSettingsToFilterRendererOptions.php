<?php

namespace Jankx\Filter\Transformer;

use Jankx\Filter\FilterOptions;
use Jankx\Filter\FilterData;
use Jankx\Filter\FilterOption;

class WidgetSettingsToFilterRendererOptions
{
    protected $widgetSettings;
    protected $options = array();

    public function __construct($widgetSettings)
    {
        if (is_array($widgetSettings)) {
            $this->widgetSettings = $widgetSettings;
        }

        $this->transformToFilterOptions();
    }

    protected function transformTaxonomyData($taxonomy, $terms, $label = null)
    {
        if (is_null($label)) {
            $taxonomy_obj = get_taxonomy($taxonomy);
            $label = $taxonomy_obj->label;
        }
        $filterData = new FilterData('taxonomy', $label, $taxonomy);

        if (in_array('All', array('all', 'All'))) {
            $taxonomy_args = array(
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
            );
            $terms = get_terms($taxonomy_args);

            foreach ($terms as $term) {
                $filterOption = new FilterOption($term->term_id, $term->name, $taxonomy);
                $filterData->addOption($filterOption);
            }
        }

        return $filterData;
    }

    protected function transformProductAttributes($attibute_name, $attributes, $label = null)
    {
        $realTaxonomy = sprintf('pa_%s', $attibute_name);

        return $this->transformTaxonomyData($realTaxonomy, $attributes, $label);
    }

    public function transformData()
    {
        switch (array_get($this->widgetSettings, 'data_type')) {
            case 'taxonomies':
                return $this->transformTaxonomyData(
                    array_get($this->widgetSettings, 'data_tax'),
                    array_get($this->widgetSettings, 'data_term'),
                    array_get($this->widgetSettings, 'filter_name')
                );
            case 'attributes':
            case 'woocommerce_attributes':
                return $this->transformProductAttributes(
                    array_get($this->widgetSettings, 'data_tax'),
                    array_get($this->widgetSettings, 'data_term'),
                    array_get($this->widgetSettings, 'filter_name')
                );
        }
    }

    public function transformToFilterOptions()
    {
        if (is_null($this->widgetSettings)) {
            return;
        }

        $options = new FilterOptions();
        $options->setName(
            array_get($this->widgetSettings, 'filter_name')
        );
        $options->setFilterType(
            array_get($this->widgetSettings, 'filter_type', 'simple')
        );
        $options->setDisplayType(
            array_get($this->widgetSettings, 'content_display', 'expand')
        );
        $options->setDatas(
            $this->transformData()
        );

        return $this->options = $options;
    }

    public function getOptions()
    {
        return apply_filters('jankx/filter/transform/options', $this->options);
    }
}
