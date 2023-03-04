$(function () {

    let dates = $('input[name="dates"]').daterangepicker({
        locale: {
            'format': 'DD/MM/YYYY'
        }
    });
    dates.on('apply.daterangepicker', function(ev, picker) {
        ajax_post(
            ``
        );
    });

});
