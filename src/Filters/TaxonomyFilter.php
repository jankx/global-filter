<?php

namespace Jankx\Filter\Filters;

use Jankx\Filter\Abstracts\Filter;
use Jankx\Filter\FilterTemplate;
use WP_Term;

class TaxonomyFilter extends Filter
{
    const FILTER_NAME = 'taxonomy-filter';

    protected static $hasActiveOption = false;
    protected $activeOptions = [];

    public function getName()
    {
        return static::FILTER_NAME;
    }

    public function getTitle()
    {
        return __('Taxonomy Filter', 'jankx_filter');
    }

    protected function mapParentOptionIds($options, $currentParent = 0, &$output = []) {
        foreach($options as $option) {
            if ($currentParent > 0) {
                $output[$option->getId()] = $currentParent;
            }
            if ($option->hasChildOptions()) {
                $this->mapParentOptionIds($option->getChildOptions(), $option->getId(), $output);
            }
        }
        return $output;
    }


    protected function groupOptionsByParent($options) {
        $ret = [];
        foreach($options as $optionId => $parent) {
            if (!isset($ret[$parent])) {
                $ret[$parent] = [$parent];
            }
            $ret[$parent][] = $optionId;
        }

        return $ret;
    }

    protected function mapOptionIdToArray($options)
    {
        $parentOptionsById = $this->mapParentOptionIds($options);
        $groupedOptionByParent = $this->groupOptionsByParent($parentOptionsById);

        return $groupedOptionByParent;
    }

    public function findActiveOptions($data = null)
    {
        if (!empty($this->activeOptions)) {
            return $this->activeOptions;
        }
        $queried_object = get_queried_object();
        if (is_null($data)) {
            $data = $this->getData();
        }
        if ($queried_object instanceof WP_Term && $queried_object->taxonomy === $data->getDataType()) {
            $optionIds = $this->mapOptionIdToArray($data->getOptions());
            foreach($optionIds as $parentId => $options) {
                if (!in_array($queried_object->term_id, $options)) {
                    continue;
                }
                $this->activeOptions[] = $parentId;
            }
        }

        // set status active option
        static::$hasActiveOption = !empty($this->activeOptions);

        return $this->activeOptions;
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
                'active_options' => $this->findActiveOptions($data),
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
                'has_active_option' => static::$hasActiveOption,
                'support_multiple' => apply_filters('jankx/global-filters/taxonomy-filter/enabled', false),
                'active_options' => $this->findActiveOptions(),
            )
        );
    }
}
