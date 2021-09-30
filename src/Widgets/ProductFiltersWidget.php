<?php
namespace Jankx\Filter\Widgets;

use WP_Widget;

class ProductFiltersWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('product_filters', __('Product Filters', 'jankx_'));
    }

    public function form($instance)
    {
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
            <input
                type="text"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php array_get($instance, 'title'); ?>"
            />
        </p>
        <?php
    }

    public function widget($args, $instance)
    {
    }
}
