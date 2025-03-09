<?php

namespace Jankx\Filter\Interfaces;

interface FilterDataInterface
{
    public function setId($id);

    public function getId();

    public function setName($name);

    public function getName();

    public function setDataType($dataType);

    public function getDataType();
}
