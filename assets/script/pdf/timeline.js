$(function () {

    let dates = $('input[name="dates"]').daterangepicker({
        startDate: moment(),
        minDate: moment(),
        locale: {
            'format': 'DD/MM/YYYY'
        }
    });
    dates.on('apply.daterangepicker', function (ev, picker) {
        ajax_post(

        );
    });

});
