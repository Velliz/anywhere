$(function() {

    let id_excel = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let timeline_card = $('.timeline-card').html();
    if (timeline_card !== undefined) {
        $('.timeline-card').remove();
    }

    let dates = $('input[name="dates"]').daterangepicker({
        locale: {
            'format': 'DD/MM/YYYY'
        }
    });

    dates.on('apply.daterangepicker', function (ev, picker) {
        ajax_post(
            `log_excel/search`,
            {
                range: dates.val(),
                excel_id: id_excel
            },
            null,
            function (result) {
                let log_excel = result.log_excel;

                $('.timeline-view').html(``);
                $.each(log_excel, function (key, val) {
                    let templates = $.parseHTML(timeline_card);
                    $('.timeline-sequence', templates).html(val.id);
                    $('.timeline-sent_at', templates).html(val.sent_at);
                    $('.timeline-processing_time', templates).html(val.processing_time);
                    $('.timeline-preview', templates).html(`
                        <a href="excel/timeline/${val.id}/${api_key}/${id_excel}" class="btn btn-success">Download .xlsx</a>
                    `);

                    $('.timeline-view').append(templates);
                });

                if (log_pdf.length === 0) {
                    $('.timeline-view').append(`<p><b>No data in selected range</b></p>`);
                }

            },
            function (xhr, error) {
                if (error === 'error') {
                    pnotify(`Timeline error`, xhr.responseJSON.exception.message, 'error');
                }
            }
        );
    });

});
