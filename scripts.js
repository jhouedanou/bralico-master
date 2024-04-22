$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
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
