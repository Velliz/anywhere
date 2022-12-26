$(function () {
    let username = $('input[name=username]');
    let name = $('input[name=name]');
    let email = $('input[name=email]');
    let password = $('input[name=password]');
    let repeat_password = $('input[name=repeat_password]');

    let register_submit = $('.register-submit');
    register_submit.on('click', function () {
        if (username.val().length < 3) {
            $('.ajax-register').show();
            $('.ajax-register-message').html(`Your username is to short. Please input 3 character or more.`);
            return false;
        }
        if (name.val().length < 3) {
            $('.ajax-register').show();
            $('.ajax-register-message').html(`Your name is to short. Please input 3 character or more.`);
            return false;
        }
        if (password.val().length < 6) {
            $('.ajax-register').show();
            $('.ajax-register-message').html(`Your password is to short. Please input 6 character or more.`);
            return false;
        }
        if (password.val() !== repeat_password.val()) {
            $('.ajax-register').show();
            $('.ajax-register-message').html(`Your re-type password don't match!`);
            return false;
        }

        ajax_post(
            `users/create`,
            {
                username: username.val(),
                name: name.val(),
                email: email.val(),
                password: password.val(),
            },
            null,
            function (result) {
                let users = result.users;
                $('.ajax-register').show();
                $('.ajax-register-message').html(`Your registration with email ${users.email} recorded! Please login to continue.`);

                location.replace('/login');
            },
            function (xhr, result, error) {
                $('.ajax-register').show();
                $('.ajax-register-message').html(xhr.responseJSON.exception.message);
            }
        );
    });
});
