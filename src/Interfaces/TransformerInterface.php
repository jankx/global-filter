<?php

namespace Jankx\Filter\Interfaces;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

interface TransformerInterface
{
    public function addData($data);

    public function getFilterDatas();
}
