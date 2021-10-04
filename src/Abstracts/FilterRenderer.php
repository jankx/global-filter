<?php
namespace Jankx\Filter\Abstracts;

use Jankx\Filter\Interfaces\FilterRendererInterface;
use Jankx\Filter\FilterOptions;

abstract class FilterRenderer implements FilterRendererInterface
{
    protected $options;

    public function __construct($options = null)
    {
        $this->setOptions($options);
    }

    public function setOptions($options)
    {
        if (is_a($options, FilterOptions::class)) {
            $this->options = $options;
        }
    }

    public function getOptions()
    {
        return $this->options;
    }
}
