$(document).ready(function () {
  updateNavbar();
});

function updateNavbar() {
  const loginItem = $("#login-item");
  const registerItem = $("#register-item");
  const userItem = $("#user-item");
  const logoutItem = $("#logout-item");
  const usernameSpan = $("#username");

  // Check if user is logged in
  const user = localStorage.getItem("user");

  if (user) {
    // User is logged in
    const userData = JSON.parse(user);
    usernameSpan.text(userData.username);

    loginItem.addClass("d-none");
    registerItem.addClass("d-none");
    userItem.removeClass("d-none");
    logoutItem.removeClass("d-none");
  }

  // Logout functionality
  $("#logout").click(function () {
    localStorage.removeItem("user");
    location.reload();
  });
}
