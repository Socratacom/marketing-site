function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

// Slick Slider
function slider(container, arrows, speed, slides1, slides2, slides3, scrollNum1, scrollNum2, arrowContainer) {
  if (speed === '') {
    speed = 4000;
  }
  if (slides1 === '') {
    slides1 = 1;
  }
  if (slides2 === '') {
    slides2 = slides1;
  }
  if (slides3 === '') {
    slides3 = slides1;
  }
  if (scrollNum1 === '') {
    scrollNum1 = 1;
  }
  if (scrollNum2 === '') {
    scrollNum2 = scrollNum1;
  }
  if (arrowContainer === '') {
    arrowContainer = container;
  } else {
    //arrowContainer = arrowContainer;
  }

  $(container).slick({
    arrows: arrows,
    appendArrows: arrowContainer,
    prevArrow: '<i class="fa slick-prev fa-chevron-left"></i>',
    nextArrow: '<i class="fa slick-next fa-chevron-right"></i>',
    draggable: false,
    autoplay: true,
    autoplaySpeed: speed,
    slidesToShow: slides1,
    slidesToScroll: scrollNum1,
    speed: 500,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: slides2,
          slidesToScroll: scrollNum2
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: slides3,
          slidesToScroll: 1
        }
      }
    ]
  });
}
