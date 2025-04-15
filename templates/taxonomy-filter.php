<?php
$queried_object = get_queried_object();
foreach($filter_options as $index => $option):
    $optionCls = ['filter-option'];
    if ($queried_object instanceof WP_Term && $option->getId() == $queried_object->term_id) {
        $optionCls[] = 'active';
    }
    ?>
    <div <?php echo jankx_generate_html_attributes(['class' => $optionCls]); ?>>
        <?php if($support_multiple): ?>
        <label for="<?php echo $filter_type; ?>-<?php echo $option->getDataType(); ?>-<?php echo $option->getId(); ?>">
            <input
                type="checkbox"
                class="hidden filter-control"
                id="<?php echo $filter_type; ?>-<?php echo $option->getDataType(); ?>-<?php echo $option->getId(); ?>"
                name="<?php echo esc_attr($data_type); ?>[<?php echo esc_attr($option->getDataType()); ?>][]"
                value="<?php echo esc_attr($option->getId()); ?>"
            />
            <div class="virtual-checkbox"></div>
        <?php endif; ?>
            <a href="<?php echo get_term_link($option->getId()); ?>"><?php echo $option->getName(); ?></a>
        <?php if($support_multiple): ?>
        </label>
        <?php endif; ?>

        <?php
        if ($option->hasChildOptions()) {
            $subOptionsCls = ['sub-options'];
            if ($index === 0) {
                $subOptionsCls[] = 'expanded';
            }
            echo sprintf('<div %s>', jankx_generate_html_attributes([
                'class' => $subOptionsCls
            ]));
            echo $filter->renderChildOptions(
                $option->getChildOptions(),
                $data_type
            );
            echo '</div>';
        } ?>
    </div>
<?php endforeach; ?>
