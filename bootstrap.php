<?php
if (!defined('ABSPATH')) {
    exit('Cheatin huh?');
}

use Jankx\PostLayout\PostLayoutManager;
use Jankx\Filter\BuiltInFeatures;
use Jankx\Filter\FilterManager;

if (!class_exists(Jankx_Global_Filter_Bootstrap::class)) {
    class Jankx_Global_Filter_Bootstrap
    {
        public function __construct()
        {
            $this->defineConstants();
            $this->defineFunctions();
        }

        protected function defineConstants()
        {
            define('JANKX_FILTER_ROOT_DIR', dirname(__FILE__));
        }

        public function defineFunctions()
        {
            function jankx_filter_assets_dir_url($path = '', $is_admin = false)
            {
                $root_dir = dirname(__FILE__);
                $root_dir_url = jankx_get_path_url($root_dir);

                return sprintf(
                    '%s%s/assets/%s',
                    $root_dir_url,
                    $is_admin ? '/admin' : '',
                    $path
                );
            }
        }

        public function run()
        {
            // Initialize post layout
            PostLayoutManager::getInstance();

            // Load built-in features
            BuiltInFeatures::getInstance();

            // Support Global Filter
            FilterManager::getInstance();
        }
    }
}

$bootstrap = new Jankx_Global_Filter_Bootstrap();
add_action(
    'after_setup_theme',
    array($bootstrap, 'run'),
    20
);
