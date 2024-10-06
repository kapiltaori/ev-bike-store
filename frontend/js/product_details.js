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
      $("#productImage").attr(
        "src",
        `./image/products/${productName}/${productName}_${color
          ?.replace(" ", "_")
          ?.toLowerCase()}.png`
      );

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
    const actionType =
      $(this).attr("id") === "bookNowBtn" ? "Book Now" : "Book Test Drive";
    $("#bookingModalLabel").text(actionType);
    $("#bookingModal").modal("show");
  });

  $("#bookingForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "http://localhost/ev-bike-store/backend/booking.php",
      type: "POST",
      data: $(this).serialize(),
      success: function () {
        $("#bookingModal").modal("hide");
        alert("Thanks for showing the interest and will get back to you.");
        $("#bookingForm")[0].reset();
      },
      error: function () {
        alert("There was an error processing your request.");
      },
    });
  });
});
