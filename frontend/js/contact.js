$(document).ready(function () {
  const user = localStorage.getItem("user");
  const userData = user ? JSON.parse(user) : null;
  $("#contactForm #name").val(userData?.username);
  $("#contactForm #email").val(userData?.email);
  $("#contactForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "http://localhost/ev-bike-store/backend/contact.php",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        $("#contactForm")[0].reset();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $("#alertContainer").html(
          '<div class="alert alert-success" role="alert">' + response + "</div>"
        );
      },
      error: function () {
        $("#alertContainer").html(
          '<div class="alert alert-danger" role="alert">There was an error processing your request.</div>'
        );
      },
    });
  });
});
