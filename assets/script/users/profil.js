$(function () {

    ajax_get(
        `users/data`,
        null,
        function (result) {
            let status = result.status;
            let message = result.message;
            let data = result.data;

            //fill profile user data
            $('.profile-id').html(data.user.id);
            $('.profile-username').html(data.user.email);
            $('.profile-name').html(data.user.name);
            $('.profile-status').html(data.user.status.status);
            $('.profile-limitations').html(data.user.status.limitations);
            $('.profile-api_key').html(data.user.api_key);
        },
        function (xhr, result) {
            if (result === 'error') {
                localStorage.clear();
                location.replace('/');
            }
        },
    );

});
