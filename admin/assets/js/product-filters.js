(function($){
    $('.choose-data-terms').each(function(index, element){
        element.choices = new Choices(element, {
            searchEnabled: true,
            removeItemButton: true,
        });
    });
    $(document).on('click', '.add-filter-control', function(e) {
        e.preventDefault();
        var filters_wrapper = $(this).parent();
        var controlNamePrefix = $(filters_wrapper).find('input.control_name').val();
        var currentIndex = $(filters_wrapper).find('input.current_items');

        filter = tim(window.jankx_product_filters.control_template, {
            index: parseInt(currentIndex.val()),
            control_name: controlNamePrefix,
            multiple: '',
        });

        $(filters_wrapper).find('.filters').append(filter);
        $(currentIndex).val(parseInt(currentIndex.val()) + 1);

        var newFilter = $(filters_wrapper).find('.filters .product-filter').last();
        var selectELement = newFilter.find('.choose-data-terms').get(0);
        selectELement.choices = new Choices(selectELement, {
            searchEnabled: true,
            removeItemButton: true,
        });
    });

    $(document).on('change', '.choose-data-type', function(e){
        if ($(this).val()) {
            $(this).find('option[data-specs]').remove();
        }

        var tax_wrap = $(this).parent().next().find('.choose-data-tax');
        var data_type = $(this).val();
        var data = window.jankx_product_filters[data_type] || {};
        var data_keys = Object.keys(data);
        $(tax_wrap).find('option:not([data-specs])').remove();

        if (data_keys.length > 0) {
            for(i=0;i < data_keys.length; i++) {
                option = document.createElement('option');
                option.text = data[data_keys[i]];
                option.setAttribute('value', data_keys[i]);
                $(tax_wrap).append(option);
            }
        }
    });

    $(document).on('change', '.choose-data-tax', function(e) {
        if ($(this).val()) {
            var selectElement = $(this).parents('.product-filter').find('.choose-data-terms').get(0);
            if (selectElement.choices) {
                selectElement.choices.destroy()
            }
            var terms_wrap = $(this).parent().next().find('.choose-data-terms');
            $(terms_wrap).find('option').remove();
            var terms = window.jankx_product_filters['taxonomy_' + $(this).val()] || {}
            var term_keys = Object.keys(terms);

            var option = document.createElement('option');
            option.text = jankx_filter_languages.all_item;
            $(selectElement).append(option);

            for (i=0;i < term_keys.length; i++) {
                var term_key = term_keys[i];
                var option = document.createElement('option');
                option.text = terms[term_key];
                option.setAttribute('value', term_key);

                $(selectElement).append(option);
            }

            selectElement.choices = new Choices(selectElement, {
                searchEnabled: true,
                removeItemButton: true,
            });
        }
    });

    $(document).on('click', '.collapse-filter', function(e) {
        e.preventDefault();
        $(this).parents('.product-filter').toggleClass('filter-expanded');
    });

    $(document).on('keyup', '.filters .filter-name', function() {
        $(this).parents('.product-filter').find('.title-bar').text($(this).val());
    });
})(jQuery);
