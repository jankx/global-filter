<form class="filter-options">
<?php foreach($filter_options as $option): ?>
    <div class="filter-option">
        <label for="<?php echo $filter_type; ?>-<?php echo $option->getDataType(); ?>-<?php echo $option->getId(); ?>">
            <input
                type="checkbox"
                class="hidden filter-control"
                id="<?php echo $filter_type; ?>-<?php echo $option->getDataType(); ?>-<?php echo $option->getId(); ?>"
                name="<?php echo esc_attr($data_type); ?>[<?php echo esc_attr($option->getDataType()); ?>][]"
                value="<?php echo esc_attr($option->getId()); ?>"
            />
            <div class="virtual-checkbox"></div>
            <a href="<?php echo get_term_link($option->getId()); ?>"><?php echo $option->getName(); ?></a>
        </label>
    </div>
<?php endforeach; ?>
</form>
