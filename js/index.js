$(document).ready(function() {
    $('.owl-one').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 1
          },
          1000: {
            items: 1
          }
        }
      });
    
      $('.owl-two').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 2
          },
          1000: {
            items: 3
          }
        }
      });

      anime({
        targets: '.ani_image',
        translateX: 70,
        loop: true,
        direction: 'alternate',
        easing: 'easeInOutSine'
      });
});