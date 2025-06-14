<?php

namespace Jankx\Filter\Transformer;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

use Jankx\Filter\Abstracts\Transformer;
use Jankx\Filter\FilterData;
use Jankx\Filter\FilterOption;

class ArraysToFilterDataTransformer extends Transformer
{
    protected $datas = array();

    protected static $currentData;

    public function addData($data)
    {
        if (empty($data['id'])) {
            error_log('Data do not have ID: ' . json_encode($data));
            return;
        }
        if (!isset($data['label']) && isset($data['name'])) {
            $data['label'] = $data['name'];
        }

        static::$currentData = new FilterData(
            $data['id'],
            $data['label'],
            array_get($data, 'type')
        );
        static::$currentData->setDisplayType(array_get($data, 'display_type'));

        if (is_array($data['options']) && count($data['options'])) {
            $this->addOptions($data['options']);
        }
        $this->datas[] = static::$currentData;
    }

    public function addOptions($options)
    {
        foreach ($options as $option) {
            if (!isset($option['id'], $option['label'])) {
                continue;
            }
            $optionData = new FilterOption($option['id'], $option['label']);
            if (isset($option['url'])) {
                $optionData->setUrl($option['url']);
            }

            do_action_ref_array('jankx/filter/data/option', array(
                &$option,
                static::$currentData
            ));

            static::$currentData->addOption($optionData);
        }
    }

    public function getFilterDatas()
    {
        return apply_filters('jankx/filter/data', $this->datas);
    }
}
