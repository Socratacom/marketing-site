$(document).ready(function(){
	$('.slider').slick({
		arrows: true,
		appendArrows: $('.arrowsContainer'),
		prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-chevron-left"></i></div>',
		nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-chevron-right"></i></div>',
		autoplay: true,
		autoplaySpeed: 8000,
		speed: 800,
		slidesToShow: 1,
		slidesToScroll: 1
	});
	$('.slider').show();
});





