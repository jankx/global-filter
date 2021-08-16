# Example

## Create filters via Elementor

```
<?php
use Jankx\Elementor\Widgets\Abstracts\PostTypeFilters;

class ProjectFilters extends PostTypeFilters
{
    protected $filters = array();

    public function get_name()
    {
        return 'project_filters';
    }

    public function get_title()
    {
        return __('Project Filters', 'jankx');
    }

    protected function filters()
    {
        return array(
            'project_style' => array(
                'type' => 'taxonomy',
                'taxonomy' => 'project_style',
                'label' => __('Style'),
                'display_type' => 'select'
            ),
            'project_type' => array(
                'type' => 'taxonomy',
                'taxonomy' => 'project_type',
                'label' => __('Loại hình'),
                'display_type' => 'select'
            ),
            'project_areage' => array(
                'type' => 'post_meta',
                'meta_key' => '_project_areage',
                'options' => array(
                    '0-100' => 'dưới 100m2',
                    '100-200' => '100 - 200m2',
                    '200-300' => '200 - 300m2',
                    '300-400' => '300 - 400m2',
                    '400+' => 'trên 400m2',
                ),
                'label' => __('Areage'),
                'display_type' => 'select'
            )
        );
    }
}

```