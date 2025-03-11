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
            <?php echo $option->getName(); ?>
        </label>
    </div>
<?php endforeach; ?>
