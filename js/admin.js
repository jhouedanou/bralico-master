jQuery(document).ready(function($) {
    // Filtrage par poste
    $('#job-filter').on('change', function() {
        var selectedJobId = $(this).val();
        
        if (selectedJobId === '') {
            // Afficher toutes les lignes si aucun poste n'est sélectionné
            $('#tableau-cv tr').show();
        } else {
            // Masquer/afficher les lignes selon le poste sélectionné
            $('#tableau-cv tr').each(function() {
                var jobIds = $(this).data('job-ids').toString().split(',');
                if (jobIds.indexOf(selectedJobId) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });

    // Gestion des aperçus de candidature
    $('.application-preview').each(function() {
        var $preview = $(this);
        var $quickEdit = $preview.find('.quick-edit-row');
        
        // Cacher initialement la ligne de modification rapide
        $quickEdit.hide();
        
        // Basculer l'affichage au clic
        $preview.on('click', function(e) {
            e.preventDefault();
            $quickEdit.slideToggle();
        });
    });

    // Recherche rapide
    $('#search-cv').on('input', function() {
        var searchText = $(this).val().toLowerCase();
        $('#tableau-cv tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(searchText) > -1);
        });
    });

    // Tri des colonnes
    $('.wp-list-table th').click(function() {
        var table = $(this).parents('table').eq(0);
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
        this.asc = !this.asc;
        if (!this.asc) {
            rows = rows.reverse();
        }
        for (var i = 0; i < rows.length; i++) {
            table.append(rows[i]);
        }
    });

    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index);
            var valB = getCellValue(b, index);
            return $.isNumeric(valA) && $.isNumeric(valB) ?
                valA - valB : valA.localeCompare(valB);
        };
    }

    function getCellValue(row, index) {
        return $(row).children('td').eq(index).text();
    }
});
