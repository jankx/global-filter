<?php

namespace Jankx\Filter;

use Jankx;
use Jankx\Template\Template;

class FilterTemplate
{
    protected static $templateEngine;

    public static function loadTemplate($templateName, $data = array(), $echo = true)
    {
        if (is_null(self::$templateEngine)) {
            self::$templateEngine = Template::createEngine(
                'jankx_filter',
                sprintf('templates/filters'),
                sprintf('%s/templates', JANKX_FILTER_ROOT_DIR),
                class_exists(Jankx::class) ? Jankx::getActiveTemplateEngine() : 'plates'
            );
        }
        return self::$templateEngine->render($templateName, $data, $echo);
    }
}
