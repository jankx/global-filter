<?php

namespace Jankx\Filter\Abstracts;

use Jankx\Filter\Interfaces\FilterDataInterface;

abstract class Data implements FilterDataInterface
{
    protected $id;
    protected $name;
    protected $dataType;
    protected $url;
    protected $icon;
    protected $image;

    public function __construct($id, $name, $dataType = null)
    {
        $this->setId($id);
        $this->setName($name);

        if (!is_null($dataType)) {
            $this->setDataType($dataType);
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
