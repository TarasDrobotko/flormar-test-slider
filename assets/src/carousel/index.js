(function ($) {
  class SlickCarousel {
    constructor() {
      this.initiateCarousel();
    }

    initiateCarousel() {
      $(".flormar-test-slider").slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: false,
        // the magic
        responsive: [
          {
            breakpoint: 1440,
            settings: {
              slidesToShow: 3,
            },
          },
          {
            breakpoint: 1170,
            settings: {
              arrows: false,
              slidesToShow: 2,
            },
          },
        ],
      });
    }
  }

  new SlickCarousel();
})(jQuery);
