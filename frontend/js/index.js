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

      $.ajax({
          url: 'http://localhost/ev-bike-store/backend/products.php',
          method: 'GET',
          dataType: 'json',
          success: function(data) {
              const productList = $('#product-list');
              console.log('Product data', data);
              data.forEach(product => {
                  const productItem = $('<div></div>').text(`Product ID: ${product.id} - Name: ${product.name} - Price: ${product.price}`);
                  productList.append(productItem);
              });
          },
          error: function(xhr, status, error) {
              console.error('Error fetching products:', error);
          }
      });
      updateNavbar();
});

function updateNavbar() {
  const loginItem = $('#login-item');
  const registerItem = $('#register-item');
  const userItem = $('#user-item');
  const logoutItem = $('#logout-item');
  const usernameSpan = $('#username');

  // Check if user is logged in
  const user = localStorage.getItem('user');

  if (user) {
      // User is logged in
      const userData = JSON.parse(user);
      usernameSpan.text(userData.username);

      loginItem.addClass('d-none');
      registerItem.addClass('d-none');
      userItem.removeClass('d-none');
      logoutItem.removeClass('d-none');
  }

  // Logout functionality
  $('#logout').click(function() {
      localStorage.removeItem('user');
      location.reload();
  });
}
