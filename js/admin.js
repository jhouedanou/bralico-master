jQuery(document).ready(function($) {
    // Configuration des colonnes pour le filtrage
    var colonnes = {
        'specialite': {
            'champ': '_candidate_speciality',
            'label': 'Spécialité'
        },
        'experience': {
            'champ': '_candidate_experience_years',
            'label': 'Années d\'expérience'
        },
        'highest_diploma': {
            'champ': '_candidate_highest_diploma',
            'label': 'Diplôme le plus élevé'
        }
    };

    // Création de la ligne de filtres
    var $filterRow = $('<div class="filter-row"></div>');
    
    // Ajout des filtres pour chaque colonne
    for (var colonne in colonnes) {
        var $filterGroup = $('<div class="filter-group"></div>');
        $filterGroup.append('<label for="filter-' + colonne + '">' + colonnes[colonne].label + '</label>');
        $filterGroup.append('<select id="filter-' + colonne + '" class="filter-select" data-colonne="' + colonne + '"><option value="">Tous</option></select>');
        $filterRow.append($filterGroup);
    }

    // Insertion des filtres avant le tableau
    $('.wp-list-table').before($filterRow);

    // Collecte des valeurs uniques pour chaque colonne
    $('.wp-list-table tbody tr').each(function() {
        var $row = $(this);
        for (var colonne in colonnes) {
            var valeur = $row.find('td:eq(' + getColonneIndex(colonne) + ')').text().trim();
            var $select = $('#filter-' + colonne);
            if (valeur && $select.find('option[value="' + valeur + '"]').length === 0) {
                $select.append('<option value="' + valeur + '">' + valeur + '</option>');
            }
        }
    });

    // Tri des options dans les selects
    $('.filter-select').each(function() {
        var $select = $(this);
        var $options = $select.find('option').toArray();
        $options.sort(function(a, b) {
            return $(a).text().localeCompare($(b).text());
        });
        $select.empty().append($options);
    });

    // Fonction de filtrage
    function filtrerTableau() {
        $('.wp-list-table tbody tr').each(function() {
            var $row = $(this);
            var visible = true;

            for (var colonne in colonnes) {
                var filterValue = $('#filter-' + colonne).val();
                if (filterValue) {
                    var cellValue = $row.find('td:eq(' + getColonneIndex(colonne) + ')').text().trim();
                    if (cellValue !== filterValue) {
                        visible = false;
                        break;
                    }
                }
            }

            $row.toggle(visible);
        });

        updateResultCount();
    }

    // Mise à jour du compteur de résultats
    function updateResultCount() {
        var visibleRows = $('.wp-list-table tbody tr:visible').length;
        var $count = $('.resultats-count');
        if ($count.length === 0) {
            $count = $('<div class="resultats-count"></div>');
            $('.filter-row').after($count);
        }
        $count.text(visibleRows + ' CV' + (visibleRows > 1 ? 's' : '') + ' trouvé' + (visibleRows > 1 ? 's' : ''));
    }

    // Fonction pour obtenir l'index de la colonne
    function getColonneIndex(colonne) {
        var headers = $('.wp-list-table th').map(function(index) {
            return $(this).text().toLowerCase();
        }).get();
        return headers.indexOf(colonnes[colonne].label.toLowerCase());
    }

    // Écouteurs d'événements pour le filtrage
    $('.filter-select').on('change', filtrerTableau);

    // Tri des colonnes
    $('.wp-list-table th').click(function() {
        var index = $(this).index();
        var ascending = !$(this).hasClass('asc');
        
        $('.wp-list-table th').removeClass('asc desc');
        $(this).addClass(ascending ? 'asc' : 'desc');

        var rows = $('.wp-list-table tbody tr').toArray();
        rows.sort(function(a, b) {
            var A = $(a).find('td').eq(index).text().trim();
            var B = $(b).find('td').eq(index).text().trim();
            
            if (!isNaN(A) && !isNaN(B)) {
                return ascending ? A - B : B - A;
            }
            return ascending ? A.localeCompare(B) : B.localeCompare(A);
        });

        $('.wp-list-table tbody').empty().append(rows);
    });

    // Initialisation de Thickbox
    $('.thickbox').click(function(e) {
        $('#TB_ajaxContent').html('<div class="loading-spinner"></div>');

        e.preventDefault();
        var url = $(this).attr('href');
        tb_show('', url);
    });

    // Initialisation du compteur
    updateResultCount();
});
