$(document).ready(function () {
  const productId = getProductIdFromURL();
  $.ajax({
    url: `http://localhost/ev-bike-store/backend/product_details.php?id=${productId}`,
    type: "GET",
    success: function (data) {
      const product = JSON.parse(data);
      const productName = product?.name?.toLowerCase();
      const color = Object.values(product?.colors)[0]?.color;
      const actualAmount = product?.price;
      const discountedAmount =
        actualAmount - (actualAmount * product.discount) / 100;
      $(".productName").text(product.name);
      $(".productColor").text(color);
      $("#actualAmount").html(
        `<i class="fa-solid fa-indian-rupee-sign"></i>${formatPrice(
          actualAmount
        )}`
      );
      $("#discountedAmount").html(
        `<i class="fa-solid fa-indian-rupee-sign"></i>${formatPrice(
          discountedAmount
        )}`
      );
      $("#discountText").html(
        `${
          product?.discount
            ? "Discount: " + parseInt(product?.discount) + "%"
            : ""
        }`
      );
      $("#productImage").attr(
        "src",
        `./image/products/${productName}/${productName}_${color
          ?.replace(" ", "_")
          ?.toLowerCase()}.png`
      );

      $("#productDetails")
        .html(`<div class="row align-items-center justify-content-center">
                <div class="col-4 text-center mb-3">
                  <div class="fw-bold">Riding Range</div>
                  <div class="">${product?.kms_per_charge || 0} kms</div>
                </div>
                <div class="col-4 text-center mb-3">
                  <div class="fw-bold">Charging Time</div>
                  <div class="">${product?.full_charge_in_hrs || 0} hrs</div>
                </div>
                <div class="col-4 text-center mb-3">
                  <div class="fw-bold">Top Speed</div>
                  <div>${product.top_speed || 0} kmph</div>
                </div>
                <div class="col-4 text-center mb-3">
                  <div class="fw-bold">Panel</div>
                  <div>${product?.panel}</div>
                </div>  
                <div class="col-4 text-center mb-3">
                  <div class="fw-bold">Battery</div>
                  <div>${product?.battery}</div>
                </div>
                <div class="col-4 text-center mb-3">
                  <div class="fw-bold">Battery Warranty</div>
                  <div>${product?.battery_warranty}</div>
                </div>
              </div>
              
              `);

      let descriptionHTML = "";
      product.description.split(",").forEach((desc) => {
        descriptionHTML += `<li class="m-1"><i class="fa-solid fa-check"></i>  ${desc.trim()}</li>`;
      });
      $("#productDescription").html(`<ul>${descriptionHTML}</ul>`);

      let colorOptions = "";
      Object.values(product?.colors).forEach((prod, i) => {
        colorOptions += `<span class="color-circle ${
          i === 0 ? "selected" : ""
        }" style="background-color: ${prod.color_code};" data-color="${
          prod.color
        }"></span>`;
      });
      $("#colorCircles").html(colorOptions);
      $("#colorCircles").on("click", ".color-circle", function () {
        const color = $(this).data("color");
        $(".color-circle").removeClass("selected");
        $(this).addClass("selected");
        $(".productColor").text(color);
        const newImage = `./image/products/${productName}/${productName}_${color
          ?.replace(" ", "_")
          ?.toLowerCase()}.png
        `;
        $("#productImage").attr("src", newImage);
      });
    },
    error: function () {
      alert("Error fetching product details.");
    },
  });

  function getProductIdFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("id");
  }

  $("#bookNowBtn, #bookTestDriveBtn").click(function () {
    const user = localStorage.getItem("user");
    const userData = user ? JSON.parse(user) : null;
    const actionType =
      $(this).attr("id") === "bookNowBtn" ? "Book Now" : "Book Test Drive";
    $("#isBooking").val($(this).attr("id") === "bookNowBtn");
    $("#bookingModalLabel").text(actionType);
    $("#bookingForm #name").val(userData?.username);
    $("#bookingForm #email").val(userData?.email);
    $("#alertContainer").text("");
    $("#bookingModal").modal("show");
  });

  $("#bookingForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "http://localhost/ev-bike-store/backend/booking.php",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        const res = JSON.parse(response);
        $("#bookingModal").modal("hide");
        const isBooking = $(this).attr("id") === "bookNowBtn";
        console.log("isBooking", isBooking);
        $("#alertContainer").html(
          '<div class="alert alert-success" role="alert">' +
            res?.message +
            "</div>"
        );
        $("#bookingForm")[0].reset();
      },
      error: function () {
        $("#alertContainer").html(
          '<div class="alert alert-danger" role="alert">There was an error processing your request. Please try again</div>'
        );
      },
    });
  });
});
