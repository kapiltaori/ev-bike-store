$(document).ready(function () {
  $(".filter-btn").click(function () {
    var filter = $(this).data("filter");

    // Remove active class from all buttons
    $(".filter-btn").removeClass("active");

    // Add active class to the clicked button
    $(this).addClass("active");

    if (filter == "all") {
      $(".filter-item").show();
    } else {
      $(".filter-item").hide();
      $("." + filter).show();
    }
  });
  $.ajax({
    url: "http://localhost/ev-bike-store/backend/products.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      const productList = $("#product-list");
      data.forEach((product) => {
        const productItem = $(
          `<div class="col-lg-4 filter-item ${product.name.toLowerCase()}"></div>`
        ).html(
          `
            <div class="box">
            <div class="img text-center">
              <img src="./image/${product.name.toLowerCase()}_1.jpg" alt="" style="height: 250px;" />
              <div class="flex1">
                <label>50%</label>
                <i class="fas fa-heart"></i>
              </div>
            </div>

            <div class="detalis">
              <h3>${product.name}</h3>
              <p>${product.description}</p>
              <h2><i class="fa-solid fa-indian-rupee-sign"></i> ${
                product.price
              }</h2>
              <button class="mx-3">Test Drive</button>
              <button>Buy Now</button>
            </div>
          </div>
          `
        );
        productList.append(productItem);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching products:", error);
    },
  });
});
