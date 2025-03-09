(function($){
    $(document).on('click', '.collapse-filter', function(e) {
        e.preventDefault();
        $(this).parents('.product-filter').toggleClass('filter-expanded');
    });

    $(document).on('keyup', '.filters .filter-name', function() {
        $(this).parents('.product-filter').find('.title-bar').text($(this).val());
    });
})(jQuery);
