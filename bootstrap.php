<?php
if (!class_exists(Jankx_Global_Filter_Bootstrap::class)) {
    class Jankx_Global_Filter_Bootstrap
    {
        public function run()
        {
        }
    }
}

$bootstrap = new Jankx_Global_Filter_Bootstrap();
add_action('after_theme_setup', array($bootstrap, 'run'));
