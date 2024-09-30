$(document).ready(function() {
  $('#registerForm').on('submit', function(e) {
    e.preventDefault();
    $('#response').empty();
    const formData = new FormData(this);
    $.ajax({
        url: 'http://localhost/ev-bike-store/backend/register.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          const d = JSON.parse(data);
            if (d.message) {
              const message = `<div class="alert alert-success" role="alert">${d.message}. <span>Click to <a href="/login.html">Login</a></span></div>`;
              $('#response').append(message);
            } else if (d.error) {
              const message = `<div class="alert alert-danger" role="alert">${d.error}. Please try again later.</div>`;
              $('#response').append(message);
            }
        },
        error: function(xhr, status, error) {
          const message = `<div class="alert alert-danger" role="alert">${error.message}. Please try again later.</div>`;
          $('#response').append(message);
        }
    });
  });
});
