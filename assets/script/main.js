$(function () {

    $('.guest-menu').show();

    ajax_get(
        `users/data`,
        null,
        function (result) {
            let status = result.status;
            if (status === 'success') {
                location.replace('/beranda');
            }
        },
        function (xhr, result) {
            if (result === 'error') {
                localStorage.clear();
            }
        },
    );

});
