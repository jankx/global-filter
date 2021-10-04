<?php foreach($filter_options as $option): ?>
    <div class="filter-option">
        <label for="<?php echo $filter_type; ?>-<?php echo $option->getDataType(); ?>-<?php echo $option->getId(); ?>">
            <input type="checkbox" class="hidden" id="<?php echo $filter_type; ?>-<?php echo $option->getDataType(); ?>-<?php echo $option->getId(); ?>" />
            <div class="virtual-checkbox"></div>
            <?php echo $option->getName(); ?>
        </label>
    </div>
<?php endforeach; ?>
