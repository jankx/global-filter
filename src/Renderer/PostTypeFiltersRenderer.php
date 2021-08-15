<?php
namespace Jankx\Filter\Renderer;

use WP_Query;
use Jankx\TemplateLoader;
use Jankx\Widget\Renderers\Base as RendererBase;
use Jankx\PostLayout\PostLayoutManager;
use Jankx\PostLayout\Layout\Card;

class PostTypeFiltersRenderer extends RendererBase
{
    protected $postType = 'post';
    protected $filters = array();
    protected $options = array(
        'posts_per_page' => 8,
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
        $postLayoutManager = PostLayoutManager::getInstance(TemplateLoader::getTemplateEngine());
        $postLayout = $postLayoutManager->createLayout(
            Card::LAYOUT_NAME,
            $this->generateWordPressQuery()
        );
        $postLayout->setOptions($this->layoutOptions);

        $filterWrapAttributes = array(
            'class' => array('jankx-global-filter', sprintf('style-%s-filter', array_get($this->options, 'filter_style'))),
            'data-filter-id' => array_get($options, 'instance_id', 1),
        );
        echo sprintf('<div %s>', jankx_generate_html_attributes($filterWrapAttributes));
            $postLayout->render();
            $this->writeJsVariables();
        echo '</div><!-- /.jankx-global-filter -->';
    }
}
