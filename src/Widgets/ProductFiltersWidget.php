<?php
namespace Jankx\Filter\Widgets;

use WP_Widget;
use Jankx\Filter\BuiltInFeatures;
use Jankx\Filter\Renderer\FilterRenderer;
use Jankx\Filter\Transformer\WidgetSettingsToFilterRendererOptions;

class ProductFiltersWidget extends WP_Widget
{
    protected static $printedScript = false;

    public function __construct()
    {
        parent::__construct('product_filters', __('Product Filters', 'jankx_'));
        if (!self::$printedScript) {
            add_action(
                'admin_enqueue_scripts',
                array(__CLASS__, 'registerProductFilterScripts')
            );
            static::$printedScript = true;
        }
    }

    protected static function getAllProductTaxonomies()
    {
        $taxonomies = get_object_taxonomies('product');
        $ret = array();
        foreach ($taxonomies as $taxonomy) {
            $object = get_taxonomy($taxonomy);
            if (!$object->public) {
                continue;
            }
            $ret[$taxonomy] = $object->label;
        }
        return array_unique($ret);
    }

    protected static function getAllTaxonomyTerms($taxonomy)
    {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'public' => true,
            'hide_empty' => false,
            'fields' => 'id=>name',
        ));

        return $terms;
    }

    protected static function filterDataTypes()
    {
        return apply_filters('jankx/filters/product/support_types', array(
            'taxonomies' => __('Taxonomies', 'jankx_filter'),
            'woocommerce_attributes' => __('Product Attributes', 'jankx_filter'),
            'product_meta' => __('Product Meta', 'jankx_filter'),
        ));
    }

    protected static function getAllProductAttributes()
    {
        $attributes = wc_get_attribute_taxonomies();
        $ret = array();

        foreach ($attributes as $attribute) {
            $ret[$attribute->attribute_name] = $attribute->attribute_label;
        }
        return $ret;
    }

    protected static function prepareFilterData()
    {
        $taxonomies = static::getAllProductTaxonomies();
        $attributes = static::getAllProductAttributes();

        $data = array(
            'support_types' => static::filterDataTypes(),
            'taxonomies' => $taxonomies,
            'woocommerce_attributes' => $attributes,
            'control_template' => static::filterControlTemplate(),
        );

        foreach (array_keys($taxonomies) as $taxonomy) {
            $data[sprintf('taxonomy_%s', $taxonomy)]= static::getAllTaxonomyTerms($taxonomy);
        }

        return $data;
    }

    public static function registerProductFilterScripts()
    {

        wp_register_script('tim', jankx_filter_assets_dir_url('lib/tim.js'), null, '1.0.0', true);
        wp_register_script('jankx_choices', jankx_filter_assets_dir_url('lib/choices/scripts/choices.min.js'), array(), '9.0.1', true);
        wp_register_script('jankx_filter_product', jankx_filter_assets_dir_url('js/product-filters.js', true), array('jquery', 'tim', 'jankx_choices'), '1.0.1', true);

        wp_localize_script('jankx_filter_product', 'jankx_product_filters', static::prepareFilterData());
        wp_localize_script('jankx_filter_product', 'jankx_filter_languages', array(
            'all_item' => __('All'),
        ));

        wp_enqueue_script('jankx_filter_product');

        wp_register_style('jankx_choices', jankx_filter_assets_dir_url('lib/choices/styles/choices.min.css'), array(), '1.0.1');
        wp_register_style('jankx_filter_product', jankx_filter_assets_dir_url('css/jankx-filters-widgets.css', true), array('jankx_choices'), '1.0.3');

        wp_enqueue_style('jankx_filter_product');
    }

    protected static function filterControlTemplate()
    {
        $builtInFeature = BuiltInFeatures::getInstance();
        ob_start();
        ?>
        <div class="product-filter product-filter-{{index}} filter-expanded">
            <div class="filter-title">
                <div class="title-bar"><?php _e('No name'); ?></div>
                <button class="collapse-filter">
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </button>
            </div>
            <div class="filter-content">
                <p>
                    <label for="{{control_name}}[{{index}}][filter_name]"><?php _e('Filter name'); ?></label>
                    <input
                        type="text"
                        class="widefat filter-name"
                        id="{{control_name}}[{{index}}][filter_name]"
                        name="{{control_name}}[{{index}}][filter_name]"
                        value=""
                    />
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Filter Type', 'jankx_filter')); ?></label>
                    <select name="{{control_name}}[{{index}}][filter_type]" class="widefat choose-filter-type">
                        <?php foreach ($builtInFeature->getFilters() as $filter => $args) : ?>
                            <option value="<?php echo $filter; ?>">
                                <?php echo esc_html(array_get($args, 'name')); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Data type', 'jankx_filter')); ?></label>
                    <select name="{{control_name}}[{{index}}][data_type]" class="widefat choose-data-type">
                        <option value="" data-specs="Remove after this control has value"><?php echo esc_html(__('Default')); ?></option>
                        <?php foreach (static::filterDataTypes() as $data_type => $label) : ?>
                        <option value="<?php echo esc_attr($data_type); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Choose taxonomy', 'jankx_filter')); ?></label>
                    <select name="{{control_name}}[{{index}}][data_tax]" class="widefat choose-data-tax">
                        <option value="" data-specs="Remove after this control has value"><?php echo esc_html(__('Choose a value', 'jankx_filter')); ?></option>
                    </select>
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Choose terms', 'jankx_filter')); ?></label>
                    <select name="{{control_name}}[{{index}}][data_term][]" multiple="multiple" class="widefat choose-data-terms">
                        <option value="all" class="all-item" selected><?php echo esc_html(__('All')); ?></option>
                    </select>
                </p>

                <p>
                    <label for="{{control_name}}[{{index}}][content_display]_expand">
                        <input
                            type="radio"
                            id="{{control_name}}[{{index}}][content_display]_expand"
                            name="{{control_name}}[{{index}}][content_display]"
                            value="expand"
                            checked
                        />
                        <?php echo esc_html(__('Expand', 'jankx_filter')); ?>
                    </label>

                    <label for="{{control_name}}[{{index}}][content_display]_collapse">
                        <input
                            type="radio"
                            id="{{control_name}}[{{index}}][content_display]_collapse"
                            name="{{control_name}}[{{index}}][content_display]"
                            value="collapse"
                        />
                        <?php echo esc_html(__('Collapse', 'jankx_filter')); ?>
                    </label>
                </p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    protected function render_filters($filters)
    {
        if (empty($filters)) {
            return;
        }
        $builtInFeature = BuiltInFeatures::getInstance();
        foreach ($filters as $filterIndex => $filter) :
            $selected_terms = (array)array_get($filter, 'data_term', array('all'));
            ?>
        <div class="product-filter product-filter-<?php echo $filterIndex; ?>">
            <div class="filter-title">
                <div class="title-bar"><?php echo esc_html(array_get($filter, 'filter_name', 'No name')); ?></div>
                <button class="collapse-filter">
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </button>
            </div>
            <div class="filter-content">
                <p>
                    <label for="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][filter_name]"><?php _e('Filter name'); ?></label>
                    <input
                        type="text"
                        class="widefat filter-name"
                        id="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][filter_name]"
                        name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][filter_name]"
                        value="<?php echo esc_attr(array_get($filter, 'filter_name', '')) ?>"
                    />
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Filter Type', 'jankx_filter')); ?></label>
                    <select name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][filter_type]" class="widefat choose-filter-type">
                        <?php foreach ($builtInFeature->getFilters() as $filter => $args) : ?>
                            <option value="<?php echo $filter; ?>">
                                <?php echo esc_html(array_get($args, 'name')); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Data type', 'jankx_filter')); ?></label>
                    <select name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][data_type]" class="widefat choose-data-type">
                        <?php foreach (static::filterDataTypes() as $data_type => $label) : ?>
                        <option value="<?php echo esc_attr($data_type); ?>"<?php selected(array_get($filter, 'data_type'), $data_type); ?>><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Choose taxonomy', 'jankx_filter')); ?></label>
                    <select name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][data_tax]" class="widefat choose-data-tax">
                        <option value="" data-specs="Remove after this control has value"><?php echo esc_html(__('Choose a value', 'jankx_filter')); ?></option>
                    </select>
                </p>
                <p>
                    <label for=""><?php echo esc_html(__('Choose terms', 'jankx_filter')); ?></label>
                    <select name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][data_term][]" multiple="multiple" class="widefat choose-data-terms">
                        <option value="all" class="all-item"<?php selected(in_array('all', $selected_terms)); ?>><?php echo esc_html(__('All')); ?></option>
                    </select>
                </p>

                <p>
                    <label for="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][content_display]_expand">
                        <input
                            type="radio"
                            id="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][content_display]_expand"
                            name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][content_display]"
                            value="expand"
                            checked
                        />
                        <?php echo esc_html(__('Expand', 'jankx_filter')); ?>
                    </label>

                    <label for="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][content_display]_collapse">
                        <input
                            type="radio"
                            id="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][content_display]_collapse"
                            name="<?php echo $this->get_field_name('filters'); ?>[<?php echo $filterIndex; ?>][content_display]"
                            value="collapse"
                        />
                        <?php echo esc_html(__('Collapse', 'jankx_filter')); ?>
                    </label>
                </p>
            </div>
        </div>
            <?php
        endforeach;
    }

    public function form($instance)
    {
        $filters = array_get($instance, 'filters');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
            <input
                type="text"
                class="widefat"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo array_get($instance, 'title'); ?>"
            />
        </p>

        <div class="jankx-product-filters filters-wrapper">
            <input type="hidden" class="control_name" value="<?php echo $this->get_field_name('filters'); ?>" />
            <input type="hidden" class="current_items" value="0" />

            <div class="filters jankx-filters">
                <?php $this->render_filters($filters); ?>
            </div>

            <button class="button button-default add-filter-control" style="line-height: 20px;">
                <span class="dashicons dashicons-plus"></span>
                <?php echo esc_html(__('Add new filter', 'jankx_filter')); ?>
            </button>
        </div>
        <?php
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'];
            echo array_get($instance, 'title');
            echo $args['after_title'];
        }
        $filters = array_get($instance, 'filters', []);
        ?>
            <div class="products-filter-content">
                <?php
                foreach ($filters as $filter) {
                    $filterOptionsTransformer = new WidgetSettingsToFilterRendererOptions($filter);
                    $filterRenderer = new FilterRenderer($filterOptionsTransformer->getOptions());
                    $filterRenderer->render();
                }
                ?>
            </div>
            <?php
            echo $args['after_widget'];
    }
}
