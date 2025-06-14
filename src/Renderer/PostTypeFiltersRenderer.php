<?php

namespace Jankx\Filter\Renderer;

if (!defined('ABSPATH')) {
    exit('Cheatin huh?');
}

use WP_Query;
use Jankx\TemplateAndLayout;
use Jankx\Widget\Renderers\Base as RendererBase;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\PostLayout\Layout\Card;
use Jankx\Filter\FilterManager;

class PostTypeFiltersRenderer extends RendererBase
{
    protected $postType = 'post';

    protected $filters = array();
    protected $options = array(
        'posts_per_page' => 8,
        'filters' => [],
    );
    protected $layoutOptions = array(
        'columns' => 4,
    );

    protected function setPostType()
    {
    }

    protected function generateWordPressQuery()
    {
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => array_get($this->options, 'posts_per_page', 8),
        );


        $filters = array_get($this->options, 'filters');
        if (isset($filters[0])) {
            $firstOption = $filters[0]->getFirstOption();
        }

        return new WP_Query($args);
    }

    public function addFilter()
    {
    }

    protected function writeJsVariables()
    {
        $variableName = sprintf('jankx_filter_%d_configrations', array_get($this->options, 'instance_id', 1));
        $configurations = array(
            'post_layout' => array_get($this->options, 'post_layout', Card::LAYOUT_NAME),
        );
        ?>
        <script type="text/javascript">var <?php echo $variableName; ?> = <?php echo json_encode($configurations); ?>;</script>
        <?php
    }

    public function render()
    {
        $filters = array_get($this->options, 'filters', []);
        if (empty($filters)) {
            if (current_user_can('manage_theme')) {
                echo __('The filter is not set. Please added the filter to use this widget', 'jankx_filter');
            }
            return;
        }
        $filterStyle = array_get($this->options, 'filter_style', 'simple');
        $filterManager = FilterManager::getInstance();
        $filter = $filterManager->getFilterStyle($filterStyle);
        if (empty($filter)) {
            error_log(sprintf('The "%s" filter is invalid', $filterStyle));
            return;
        }

        $postLayoutManager = PostLayoutManager::getInstance(TemplateAndLayout::getTemplateEngine());
        $postLayout = $postLayoutManager->createLayout(
            Card::LAYOUT_NAME,
            $this->generateWordPressQuery()
        );
        $postLayout->setOptions($this->layoutOptions);
        $filter->setData(array_get($this->options, 'filters'));

        $filterWrapAttributes = array(
            'class' => array('jankx-global-filter', sprintf('style-%s-filter', array_get($this->options, 'filter_style'))),
            'data-filter-id' => array_get($this->options, 'instance_id', 1),
        );
        echo sprintf('<div %s>', jankx_generate_html_attributes($filterWrapAttributes));
            // Render filter content with Post layout
            $filter->render();
            $postLayout->render();

            // Write JS variables to support filter data without reload page
            $this->writeJsVariables();
        echo '</div><!-- /.jankx-global-filter -->';
    }
}
