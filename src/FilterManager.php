<?php
namespace Jankx\Filter;

use WP_Term;
use Jankx\Filter\Filters\SimpleFilter;
use Jankx\PostLayout\Request\PostsFetcher;

class FilterManager
{
    const VERSION = '1.0.0.12';

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

    protected function detect_conditions($queried_object)
    {
        if (is_a($queried_object, WP_Term::class)) {
            switch ($queried_object->taxonomy) {
                case 'product_cat':
                case 'product_tag':
                    return array(
                        'taxonomy' => array(
                            $queried_object->taxonomy => array($queried_object->term_id),
                        )
                    );
            }
        }
        return array();
    }

    public function registerScripts()
    {
        $queried_object = get_queried_object();
        $current_conditions = apply_filters(
            'jankx/filter/current_conditions',
            $this->detect_conditions($queried_object),
            $queried_object
        );

        js(
            'jankx-global-filter',
            $this->asset_url('js/global-filter.js'),
            array('choices', 'jankx-post-layout'),
            static::VERSION,
            true
        )
        ->localize('jkx_global_filter', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'action' => PostsFetcher::FETCH_POSTS_ACTION,
            'current_conditions' => (object)$current_conditions,
        ))
        ->enqueue();

        css(
            'jankx-global-filter',
            $this->asset_url('css/global-filter.css'),
            array('choices'),
            static::VERSION
        )->enqueue();
    }
}
