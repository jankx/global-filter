<?php

namespace Jankx\Filter\Interfaces;

if (!defined('ABSPATH')) {
    exit('Cheatin huh?');
}

interface TransformerInterface
{
    public function addData($data);

    public function getFilterDatas();
}
