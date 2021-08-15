<?php
namespace Jankx\Filter\Transformer;

use Jankx\Filter\Abstracts\Transformer;
use Jankx\Filter\FilterData;
use Jankx\Filter\FilterOption;

class ArraysToFilterDataTransformer extends Transformer
{
    protected $data = array();

    public function addData($data)
    {
        if (empty($data['id'])) {
            return;
        }
        if (!isset($data['label']) && isset($data['name'])) {
            $data['label'] = $data['name'];
        }

        $this->data = new FilterData($data['id'], $data['label'], array_get($data, 'type'));
        if (is_array($data['options']) && count($data['options'])) {
            $this->addOptions($data['options']);
        }
    }

    public function addOptions($options)
    {
        foreach ($options as $option) {
            if (!isset($option['id'], $option['label'])) {
                continue;
            }
            $optionData = new FilterOption($option['id'], $option['label']);
            if (isset($option['url'])) {
                $optionData->setUrl($url);
            }

            do_action_ref_array('jankx/filter/data/option', array(
                &$option,
                &$this->data
            ));


            $this->data->addOption($option);
        }
    }

    public function getFilterDatas()
    {
        return apply_filters('jankx/filter/data', $this->data);
    }
}
