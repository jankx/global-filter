<?php

namespace Jankx\Filter;

if (!defined('ABSPATH')) {
    exit('Cheating huh?');
}

use Jankx\Filter\Filters\TaxonomyFilter;
use Jankx\Filter\Widgets\ProductFiltersWidget;
use Jankx\Filter\Filters\SimpleFilter;
use Jankx\Filter\Filters\MultiValuesFilter;

class BuiltInFeatures
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        add_action('widgets_init', array($this, 'registerWidgets'));
    }

    public function registerWidgets()
    {
        $activePlugins = get_option('active_plugins');
        if (in_array('woocommerce/woocommerce.php', $activePlugins)) {
            register_widget(ProductFiltersWidget::class);
        }
    }

    public function getFilters()
    {
        $builtInFilters = array(
            'simple' => array(
                'name' => __('Simple', 'jankx_filter'),
                'filter_class' => SimpleFilter::class
            ),
            'multi_values' => array(
                'name' => __('Multi Values', 'jankx_filter'),
                'filter_class' => MultiValuesFilter::class
            ),
            'taxonomy' => [
                'name' => __('Taxonomy', 'jankx_filter'),
                'filter_class' => TaxonomyFilter::class
            ]
        );

        return apply_filters('jankx/global/filters', $builtInFilters);
    }
}
