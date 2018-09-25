(function($) {
    // Update active menu item based on path.
    $('a[href="' + window.location.pathname + '"]').parent('li').addClass('active');

    // Enhance select dropdowns with chosen plugin.
    $('.chosen-select').chosen({width: "100%"});
})(jQuery);