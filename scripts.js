jQuery(document).ready(function ($) {
	//si la div #emploi existe
	if ($('#emploi').length) {
		var $grid = $('#emploi').imagesLoaded(function() {
			// initialise Isotope après que toutes les images aient été chargées
			$grid.isotope({
				itemSelector: '.item',
				layoutMode: 'fitRows'
			});
			
		});
		//filtre des statuts
		$('#statut-filter').on('change', function() {
			var filterValue = this.value;
			$grid.isotope({ filter: filterValue });
		});
		//filtre des lieu
		$('#lieu-filter').on('change', function() {
			var filterValue = this.value;
			$grid.isotope({ filter: filterValue });
		});
		//filtre des secteurs
		$('#secteurs-filter').on('change', function() {
			var filterValue = this.value;
			$grid.isotope({ filter: filterValue });
		});
		//filtre des type de contrat
		$('#fonctions-filter').on('change', function() {
			var filterValue = this.value;
			$grid.isotope({ filter: filterValue });
		});
	}
	
	$('#sidebarCollapse').on('click', function () {
	});
	
	$('#closeSidebar').on('click', function () {
	});
	$("#mayi .col").each(function() {
		$(this).hover(function() {
			$("#mayi .col").not(this).css("opacity", "0.5");
			$(this).css("opacity", "1");
		}, function() {
			$("#mayi .col").css("opacity", "1");
		});
	});
});
$(() => {
	//On Scroll Functionality
	$(window).scroll(() => {
		var windowTop = $(window).scrollTop();
		windowTop > 100 ? $('#masthead').addClass('navShadow') : $('#masthead').removeClass('navShadow');
		// windowTop > 100 ? $('#masthead ul').css('top', '0px') : $('#masthead ul').css('top', '0px');
	});

	//Click Logo To Scroll To Top
	$('.custom-logo').on('click', () => {
		$('html,body').animate(
			{
				scrollTop: 0
			},
			500
		);
	});
});
