jQuery(document).ready(function ($) {
//si la div #postsidebar existe, rendre la div #postsidebar sticky lorsque l'utilisateur srolle à plus de 100px en dessous de la div #masthead
	if ($('#postsidebar').length) {
		$("#postsidebar").stickOnScroll({
			topOffset: $('#masthead').outerHeight(),
			setParentOnStick:   true,
			setWidthOnStick:    true,
		});
	}

    var win = $(this); // this = window
    if (win.width() <= 1024) { 
        $('.carousel-item').removeClass('active');
        $('.carousel-item').first().addClass('active');
        $('.carousel-item').not(':first').remove();
    }
	//si la div #thumbnailpage existe
	if ($('#thumbnailpage').length) {
		// véfifier si elle contient une image et récupérer la hauteur de l'image
		var imgHeight = $('#thumbnailpage img').height();
		// ajuster la taille du pseudo element ::before à la taille de l'image
		$('#thumbnailpage').css('height', imgHeight);
	}
	if($('#filtre').length){
		//rendre chaque .modal-header sticky lorsque l'utilisateur srolle à plus de 100px
	
		$(".modal-header").stickOnScroll({
			setParentOnStick:   true,
			setWidthOnStick:    true,
		});
		}
		
	//si la div #porsche existe

	if ($('#porsche').length) {
		// rendre la div #porsche sticky lorsque l'utilisateur srolle à plus de 100px
		$("#porsche").stickOnScroll({
			topOffset: $('#masthead').outerHeight(),
			setParentOnStick:   true,
			setWidthOnStick:    true,
			topOffset: $('#masthead').outerHeight(),
		});
	}

	//si la div #emploi existe
	if ($('#emploi').length) {
		// initialisation de Isotope
		var initial_items = 8;
		var next_items = 4;
		var $grid = $('#emploi').imagesLoaded(function () {
			// initialise Isotope après que toutes les images aient été chargées
			$grid.isotope({
				itemSelector: '.element-item',
				layoutMode: 'fitRows',
			});
		});

		// Créez un objet pour stocker les valeurs de filtre
		var filters = {};

		$('.filter').on('change', function () {
			var $select = $(this);
			// Utilisez l'attribut 'id' comme groupe de filtres
			var filterGroup = $select.attr('id');
			// Utilisez la valeur de l'option sélectionnée comme valeur de filtre
			var filterValue = $select.val();
			if (filterValue) {
				filters[filterGroup] = filterValue;   
				 // Affichez le bouton si une option est sélectionnée
				$('#resetfilter').show();
			} else {
				delete filters[filterGroup];
				  // Cachez le bouton si aucune option n'est sélectionnée
				  if ($.isEmptyObject(filters)) {
					$('#resetfilter').hide();
				}
			}

			// Combine les valeurs de filtre
			var filterValue = concatValues(filters);

			// Applique les filtres à la grille Isotope
			$grid.isotope({ filter: filterValue });

			updateFilterCounts();
		});

		// Cette fonction combine les valeurs de filtre en une seule chaîne
		function concatValues(obj) {
			var value = '';
			for (var prop in obj) {
				value += obj[prop];
			}
			return value;
		}

		//ajouter plus d'éléments
		function updateFilterCounts() {
			// get filtered item elements
			var itemElems = $grid.isotope('getFilteredItemElements');
			var count_items = $(itemElems).length;

			if (count_items > initial_items) {
				$('#showMore').show();
			} else {
				$('#showMore').hide();
			}
			if ($('.element-item').hasClass('visible_item')) {
				$('.element-item').removeClass('visible_item');
			}
			var index = 0;

			$(itemElems).each(function () {
				if (index >= initial_items) {
					$(this).addClass('visible_item');
				}
				index++;
			});
			$grid.isotope('layout');
		}

		function showNextItems(pagination) {
			var itemsMax = $('.visible_item').length;
			var itemsCount = 0;
			$('.visible_item').each(function () {
				if (itemsCount < pagination) {
					$(this).removeClass('visible_item');
					itemsCount++;
				}
			});
			if (itemsCount >= itemsMax) {
				$('#showMore').hide();
			}
			$grid.isotope('layout');
		}

		// function that hides items when page is loaded
		function hideItems(pagination) {
			var itemsMax = $('.element-item').length;
			var itemsCount = 0;
			$('.element-item').each(function () {
				if (itemsCount >= pagination) {
					$(this).addClass('visible_item');
				}
				itemsCount++;
			});
			if (itemsCount < itemsMax || initial_items >= itemsMax) {
				$('#showMore').hide();
			}
			$grid.isotope('layout');
		}

		$('#showMore').on('click', function (e) {
			e.preventDefault();
			showNextItems(next_items);
		});
		hideItems(initial_items);

		//fusionner les filtres
		function concatValues(obj) {
			var value = '';
			for (var prop in obj) {
				value += obj[prop];
			}
			return value;
		}
		$('#resetfilter').hide();
		//reinitialiser les filtres
		$('#resetfilter').on('click', function(e) {
			e.preventDefault();
			$('#resetfilter').hide();
			// Réinitialisez les filtres
			filters = {};
		
			// Réinitialisez tous les select à leur valeur par défaut
			$('.filter').val('');
		
			// Réappliquez les filtres à la grille Isotope
			$grid.isotope({ filter: '*' });
		});
	}

	$('#sidebarCollapse').on('click', function () {});

	$('#closeSidebar').on('click', function () {});

	$("#mayi .col").each(function () {
		$(this).hover(
			function () {
				$("#mayi .col").not(this).css("opacity", "0.5");
				$(this).css("opacity", "1");
			},
			function () {
				$("#mayi .col").css("opacity", "1");
			}
		);
	});

});

/* 
if ($('#secteurs-filter').length) {
	document.getElementById('secteurs-filter').addEventListener('change', function() {
		this.classList.add('no-border');
	});
} */
function goBack() {
	window.history.back();
}