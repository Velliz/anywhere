//auth check process
$(function () {

    ajax_get(
        `users/data`,
        null,
        function (result) {
            let status = result.status;
            let message = result.message;
            let data = result.data;

            $('.auth-menu').show();

            //fill user data
            $('.auth-username').html(data.user.email);
            $('.auth-name').html(data.user.name);
            $('.auth-status').html(data.user.status.status);
            $('.auth-limitations').html(data.user.status.limitations);
            $('.auth-api_key').html(data.user.api_key);
        },
        function (xhr, result) {
            if (result === 'error') {
                localStorage.clear();
                location.replace('/');
            }
        },
    );

});

