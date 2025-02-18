jQuery(document).ready(function($) {
    // Remplacer aria-hidden par inert sur les éléments focusables
    $('[aria-hidden="true"]').each(function() {
        if ($(this).find(':focusable').length) {
            $(this).removeAttr('aria-hidden').attr('inert', '');
        }
    });
});
