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

    protected function transformTaxonomyData($taxonomy, $terms_ids, $label = null)
    {
        if (is_null($label)) {
            $taxonomy_obj = get_taxonomy($taxonomy);
            $label = $taxonomy_obj->label;
        }
        $filterData = new FilterData('taxonomy', $label, $taxonomy);

        $taxonomy_args = array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        );
        $terms = [];

        if (in_array('all', $terms)) {
            $terms = get_terms($taxonomy_args);
        } else {
            $taxonomy_args['include'] = $terms_ids;
            $terms = get_terms($taxonomy_args);
        }

        foreach ($terms as $term) {
            $filterOption = new FilterOption($term->term_id, $term->name, $taxonomy);
            $filterData->addOption($filterOption);
        }
        return $filterData;
    }

    protected function transformProductMeta($metaKey, $options, $label = null)
    {
        $filterData = new FilterData('meta', $label, 'meta');

        foreach ($options as $filterRule => $label) {
            $filterOption = new FilterOption($filterRule, $label, $metaKey);
            $filterData->addOption($filterOption);
        }

        return $filterData;
    }

    protected function transformProductAttributes($attibute_name, $attributes, $label = null)
    {
        $realTaxonomy = sprintf('pa_%s', $attibute_name);

        return $this->transformTaxonomyData($realTaxonomy, $attributes, $label);
    }

    protected function cleanNumberValue($number)
    {
        if (preg_match('/([\d\,\.]{1,})/', $number, $maches)) {
            $number = $maches[1];
        }
        if (($dotPos = strpos($number, '.')) !== false && ($commasPos = strpos($number, ',')) !== false) {
            // normal case. e.g: 4,545,787.56
            if ($dotPos > $commasPos) {
                $number = str_replace(',', '', $number);
            } else {
                //abnormal case. e.g: 4.545.787,56
                $number = str_replace('.', '', $number);
                $number = str_replace(',', '.', $number);
            }
        } else {
            // case 1.545.787 and 1,545,787
            $number = preg_replace('/[^\d]/', '', $number);
        }
        return $number;
    }

    protected function convertRawDataToKey($data, $separator, $currentIndex)
    {
        $key = '';

        if (strpos($data, $separator) !== false) {
            $sepdata = explode($separator, $data);

            foreach ($sepdata as $index => $value) {
                $sepdata[$index] = $this->cleanNumberValue($value);
            }
            $key = implode($separator, $sepdata);
        } elseif ($currentIndex === 0) {
            $key = implode($separator, [0, $this->cleanNumberValue($data)]);
        } else {
            $key = $this->cleanNumberValue($data);
        }

        return $key;
    }

    protected function convertRawDataToNumber($rawData, $widgetSettings)
    {
        $ret = [];
        $separator = apply_filters(
            'jankx/filter/meta_filter/separator',
            '-',
            $widgetSettings
        );

        foreach ($rawData as $index => $data) {
            $ret[$this->convertRawDataToKey($data, $separator, $index)] = $data;
        }
        return $ret;
    }

    protected function getCustomData($widgetSettings)
    {
        $customData = array_get($widgetSettings, 'data_term_custom');
        if (empty($customData)) {
            return [];
        }

        $data = explode(',', $customData);

        return $this->convertRawDataToNumber(array_map(function ($item) {
            // Fix > character is Choices.js v9
            $item = str_replace(['&rt;'], ['&gt;'], $item);

            $item = html_entity_decode($item);
            return trim($item);
        }, $data), $widgetSettings);
    }

    public function transformData()
    {
        $customData = $this->getCustomData($this->widgetSettings);

        switch (array_get($this->widgetSettings, 'data_type')) {
            case 'taxonomies':
                return $this->transformTaxonomyData(
                    array_get($this->widgetSettings, 'data_tax'),
                    !empty($customData) ? $customData : array_get($this->widgetSettings, 'data_term'),
                    array_get($this->widgetSettings, 'filter_name')
                );
            case 'attributes':
            case 'woocommerce_attributes':
                return $this->transformProductAttributes(
                    array_get($this->widgetSettings, 'data_tax'),
                    !empty($customData) ? $customData : array_get($this->widgetSettings, 'data_term'),
                    array_get($this->widgetSettings, 'filter_name')
                );
            case 'product_meta':
                return $this->transformProductMeta(
                    array_get($this->widgetSettings, 'data_tax'),
                    !empty($customData) ? $customData : array_get($this->widgetSettings, 'data_term'),
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
