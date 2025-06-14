<?php
if (!defined('ABSPATH')) {
    exit('Cheatin huh?');
}
foreach($filter_options as $index => $option):
    $optionCls = ['filter-option'];
    if (is_array($active_options) && in_array($option->getId(), $active_options)) {
        $optionCls[] = 'active';
    }
    if ($option->hasChildOptions()) {
        $optionCls[] = 'collapse';
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
            <a href="<?php echo get_term_link($option->getId()); ?>">
                <?php echo $option->getName(); ?>
                <?php if ($option->hasChildOptions()): ?>
                    <i class="arrow"></i>
                <?php endif; ?>
            </a>
        <?php if($support_multiple): ?>
        </label>
        <?php endif; ?>

        <?php
        if ($option->hasChildOptions()) {
            $subOptionsCls = ['sub-options'];
            if (is_array($active_options) && in_array($option->getId(), $active_options)) {
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
