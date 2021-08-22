<?php
namespace Jankx\Filter;

use Jankx\Filter\Filters\SimpleFilter;

class FilterManager
{
    const VERSION = '1.0.0.10';

    protected $filterStyles;
    protected $rootDirUrl;

    protected static $instance;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        if (!did_action('wp_enqueue_scripts')) {
            add_action('wp_enqueue_scripts', array($this, 'registerScripts'));
        }

        $this->filterStyles = array(
            'simple' => new SimpleFilter(),
        );
    }

    public function getFilterStyles($refresh = true)
    {
        return apply_filters(
            'jankx/filter/global/styles',
            $this->filterStyles
        );
    }

    public function getFilterStyle($filterName)
    {
        $styles = $this->getFilterStyles(false);
        if (isset($styles[$filterName])) {
            return $styles[$filterName];
        }
    }

    protected function asset_url($path = '')
    {
        if (is_null($this->rootDirUrl)) {
            $this->rootDirUrl = jankx_get_path_url(dirname(__DIR__));
        }
        return sprintf('%s/assets/%s', $this->rootDirUrl, $path);
    }

    public function registerScripts()
    {
        js(
            'jankx-global-filter',
            $this->asset_url('js/global-filter.js'),
            array('choices'),
            static::VERSION,
            true
        )->enqueue();

        css(
            'jankx-global-filter',
            $this->asset_url('css/global-filter.css'),
            array('choices'),
            static::VERSION
        )->enqueue();
    }
}
