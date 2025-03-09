<div class="jankx-filter jankx-global-filter <?php echo esc_attr($filter_type); ?><?php echo $display_type ? ' ' . $display_type : ''; ?>" data-dest-layout="<?php echo $destination_layout; ?>">
    <div class="filter-header">
        <?php if($name): ?><h3 class="filter-name"><?php echo $this->e($name); ?></h3><?php endif; ?>
        <button class="collapse-button">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTEiIGhlaWdodD0iNiIgdmlld0JveD0iMCAwIDExIDYiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0xIDFMNS41IDVMMTAgMSIgc3Ryb2tlPSIjNDY0NjQ2Ii8+Cjwvc3ZnPgo=" alt="Collapse" />
        </button>
    </div>
