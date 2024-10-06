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
        const productName = product?.name?.toLowerCase();
        const actualAmount = product?.price;
        const discountedAmount =
          actualAmount - (actualAmount * product.discount) / 100;
        const productItem = $(
          `<div class="col-lg-4 filter-item ${product.name.toLowerCase()}"></div>`
        ).html(
          `
            <div class="box">
            <div class="img text-center">
              <img src="./image/products/${productName}/${productName}_1.png" alt="" style="height: 250px;" />
              ${
                product.discount > 0
                  ? `
              <div class="flex1">
                <label>${parseInt(product.discount) + "%"}</label>
                <i class="fas fa-heart"></i>
              </div>
              `
                  : ""
              }
              
            </div>

            <div class="detalis mt-3 text-center">
              <h3 class="text-center">${product.name}</h3>
              <p>${product.description}</p>
              <h2><i class="fa-solid fa-indian-rupee-sign"></i> ${formatPrice(
                discountedAmount
              )}
              <span><i class="fa-solid fa-indian-rupee-sign"></i> ${formatPrice(
                actualAmount
              )}</span>
              </h2>
              <button class="view-details-btn" data-id="${
                product.id
              }">View Details</button>
            </div>
          </div>
          `
        );
        productList.append(productItem);
        $(".view-details-btn").click(function () {
          const productId = $(this).data("id");
          window.location.href = `product_detail.html?id=${productId}`;
        });
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching products:", error);
    },
  });
});
