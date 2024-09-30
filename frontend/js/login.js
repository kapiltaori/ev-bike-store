$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $('#response').empty();
        const formData = new FormData(this);
        $.ajax({
            url: 'http://localhost/ev-bike-store/backend/login.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const responseObject = JSON.parse(response);
                if (responseObject.message) {
                    $('#loginForm')[0].reset();
                    localStorage.setItem('user', JSON.stringify(responseObject?.user));
                    window.location.href = '/';      
                } else if (responseObject.error) {
                    const message = `<div class="alert alert-danger" role="alert">${responseObject.error}. Please try again later.</div>`;
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

