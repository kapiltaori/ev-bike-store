$(document).ready(function () {
  function updateCountdown() {
    var endTime = new Date("December 31, 2024 23:59:59").getTime();
    var now = new Date().getTime();
    var timeLeft = endTime - now;

    var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    var hours = Math.floor(
      (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    function addLeadingZero(num) {
      return num < 10 ? "0" + num : num;
    }

    $(".time #days").text(addLeadingZero(days));
    $(".time #hours").text(addLeadingZero(hours));
    $(".time #minutes").text(addLeadingZero(minutes));
    $(".time #seconds").text(addLeadingZero(seconds));
  }

  setInterval(updateCountdown, 1000);
  updateCountdown();

  $("#home_view_details").click(function () {
    const productId = $(this).data("id");
    window.location.href = `product_detail.html?id=${productId}`;
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
        const productItem = $(`<div class="col-lg-4"></div>`).html(
          `<div class="box">
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
              <h3 class="text-center mb-2">${product.name}</h3>
              <div class="d-flex my-2 align-items-center justify-content-between">
                <div>
                  <div class="fw-bold">Riding Range</div>
                  <div>${product?.kms_per_charge || 0} kms</div>
                </div>
                <div>
                  <div class="fw-bold">Charging Time</div>
                  <div>${product?.full_charge_in_hrs || 0} hrs</div>
                </div>
                <div>
                  <div class="fw-bold">Top Speed</div>
                  <div>${product.top_speed || 0} kmph</div>
                </div>
              </div>
              <p>${product.description}</p>
              <h2><i class="fa-solid fa-indian-rupee-sign"></i> ${formatPrice(
                discountedAmount
              )}
              ${
                product.discount > 0
                  ? `<span><i class="fa-solid fa-indian-rupee-sign"></i> ${formatPrice(
                      actualAmount
                    )}</span>`
                  : ""
              }
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
