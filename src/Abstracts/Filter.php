<?php
namespace Jankx\Filter\Abstracts;

use Jankx\Filter\Interfaces\FilterInterface;

abstract class Filter implements FilterInterface
{
    protected $data;

    public function __construct($data = null)
    {
        if (!is_null($data)) {
            $this->setData($data);
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    protected function afterFormContent()
    {
        do_action('jankx/filter/form/content/after');
    }
}
