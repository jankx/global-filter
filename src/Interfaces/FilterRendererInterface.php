<?php

namespace Jankx\Filter\Interfaces;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

interface FilterRendererInterface
{
    public function render();
}
