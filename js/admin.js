jQuery(document).ready(function($) {
    var colonnes = {
        'specialite': {
            'champ': '_candidate_speciality',
            'label': 'Spécialité'
        },
        'diplome': {
            'champ': '_candidate_diploma',
            'label': 'Diplôme'
        },
        'experience': {
            'champ': '_candidate_experience_years',
            'label': 'Expérience'
        }
    };

    $('<input type="text" id="recherche-cv" class="recherche-input" placeholder="Recherche rapide...">').insertBefore('.wp-list-table');

    var filterRow = $('<div class="filter-row"></div>');
    Object.keys(colonnes).forEach(function(colonne) {
        var filterGroup = $('<div class="filter-group"></div>');
        var label = $('<label for="filter-' + colonne + '">' + colonnes[colonne].label + '</label>');
        var searchInput = $('<input type="text" class="select-search" placeholder="Rechercher ' + colonnes[colonne].label + '..." data-colonne="' + colonne + '">');
        var select = $('<select class="filter-select" data-colonne="' + colonne + '"><option value="">Tous</option></select>');
        
        filterGroup.append(label);
        filterGroup.append(searchInput);
        filterGroup.append(select);
        filterRow.append(filterGroup);

        // Remplissage des options
        var options = new Set();
        $('.wp-list-table tbody tr').each(function() {
            var index = Object.keys(colonnes).indexOf(colonne) + 1;
            var value = $(this).find('td').eq(index).text().trim();
            if (value) options.add(value);
        });
        
        Array.from(options).sort().forEach(function(value) {
            select.append($('<option>', {
                value: value,
                text: value
            }));
        });
    });
    filterRow.insertBefore('.wp-list-table');

    // Gestion des filtres combinés
    $('.filter-select, .select-search').on('change keyup', function() {
        $('.wp-list-table tbody tr').each(function() {
            var row = $(this);
            var visible = true;

            Object.keys(colonnes).forEach(function(colonne) {
                var index = Object.keys(colonnes).indexOf(colonne) + 1;
                var cellValue = row.find('td').eq(index).text().trim().toLowerCase();
                var searchValue = $('.select-search[data-colonne="' + colonne + '"]').val().toLowerCase();
                var selectValue = $('.filter-select[data-colonne="' + colonne + '"]').val().toLowerCase();

                if ((searchValue && !cellValue.includes(searchValue)) || 
                    (selectValue && cellValue !== selectValue)) {
                    visible = false;
                }
            });

            row.toggle(visible);
        });

        mettreAJourCompteur();
    });

    // Recherche globale
    $('#recherche-cv').on('keyup', function() {
        var recherche = $(this).val().toLowerCase();
        
        $('.wp-list-table tbody tr').each(function() {
            var texteComplet = $(this).text().toLowerCase();
            $(this).toggle(texteComplet.includes(recherche));
        });

        mettreAJourCompteur();
    });

    function mettreAJourCompteur() {
        var total = $('.wp-list-table tbody tr').length;
        var visibles = $('.wp-list-table tbody tr:visible').length;
        $('#resultats-count').text(visibles + ' CV sur ' + total);
    }

    $('<div id="resultats-count" class="resultats-count"></div>').insertAfter('.filter-row');

    // Tri des colonnes
    $('.wp-list-table th').click(function() {
        var table = $(this).parents('table').eq(0);
        var rows = table.find('tr:gt(0)').toArray().sort(comparerColonnes($(this).index()));
        this.asc = !this.asc;
        if (!this.asc) {
            rows = rows.reverse();
        }
        for (var i = 0; i < rows.length; i++) {
            table.append(rows[i]);
        }
    });

    function comparerColonnes(index) {
        return function(a, b) {
            var valA = getCellValue(a, index);
            var valB = getCellValue(b, index);
            return $.isNumeric(valA) && $.isNumeric(valB) ? 
                   valA - valB : 
                   valA.localeCompare(valB);
        };
    }

    function getCellValue(row, index) {
        return $(row).children('td').eq(index).text().trim();
    }

    // Initialisation de Thickbox pour les PDFs
    $('a.thickbox').on('click', function(e) {
        if (!e.target.classList.contains('dashicons')) {
            return true;
        }
        e.preventDefault();
        tb_show('', this.href);
    });

    mettreAJourCompteur();
});
