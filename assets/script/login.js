$(function () {
    let username = $('input[name=username]');
    let password = $('input[name=password]');
    let login_submit = $('.login-submit');

    login_submit.on('click', function () {
        if (username.val().length === 0) {
            $('.ajax-login-error').show();
            $('.ajax-login-error-message').html(`Please input your username`);
            return false;
        }
        if (password.val().length === 0) {
            $('.ajax-login-error').show();
            $('.ajax-login-error-message').html(`Please input your password`);
            return false;
        }

        ajax_post(
            `users/login`,
            {
                username: username.val(),
                password: password.val(),
            },
            null,
            function (response) {
                let status = response.status;
                let message = response.message;
                let data = response.data;

                if (status === 'error') {
                    $('.ajax-login-error').show();
                    $('.ajax-login-error-message').html(message);
                    return false;
                }
                if (status === 'success') {
                    $('.ajax-login-error').show();
                    $('.ajax-login-error-message').html(message);

                    localStorage.setItem('bearer', data.bearer);
                    location.replace('/beranda');
                }
            },
            function (response) {
                $('.ajax-login-error').show();
                $('.ajax-login-error-message').html(response);
            },
        );
    });
});
