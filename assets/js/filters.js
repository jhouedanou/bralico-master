jQuery(document).ready(function($) {
    $('#secteurs-filter').on('change', function() {
        var selectedSecteurId = $(this).val();
        
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_sous_secteurs',
                secteur_id: selectedSecteurId
            },
            success: function(response) {
                $('#sous-secteurs-filter').html(response);
            }
        });
    });
});
