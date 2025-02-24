jQuery(document).ready(function($) {
    $(document).on('forminator:form:submit:success', function(e, response) {
        if (response && typeof response.data !== 'undefined') {
            return response.data;
        }
        return {
            message: 'Formulaire soumis avec succès',
            success: true
        };
    });
});
