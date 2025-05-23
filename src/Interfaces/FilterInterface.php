<?php

namespace Jankx\Filter\Interfaces;

interface FilterInterface
{
    public function getName();

    public function getTitle();

    public function setData($data);

    public function getData();

    public function render();

    public function setOptions($options);
}
