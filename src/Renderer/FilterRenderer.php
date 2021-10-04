<?php
namespace Jankx\Filter\Renderer;

use Jankx\Filter\Abstracts\FilterRenderer as FilterRendererAbstract;
use Jankx\Filter\FilterOptions;
use Jankx\Filter\FilterTemplate;

class FilterRenderer extends FilterRendererAbstract
{
    public function render()
    {
        if (!is_a($this->options, FilterOptions::class)) {
            error_log(sprintf('The filter options is invalid: %s', json_encode($this->options)));
            return;
        }

        $filter = $this->options->getFilterType();
        $filter->setData($this->options->datas);
        $filter->setOptions($this->options);

        FilterTemplate::loadTemplate('start-filter', array(
            'name' => $this->options->getName(),
            'display_type' => $this->options->getDisplayType(),
            'filter_type' => $filter->getName(),
        ));
        $filter->render();
        FilterTemplate::loadTemplate('end-filter');
    }
}
