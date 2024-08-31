
let id_mail = $('input[name=id]').val();
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
        `log_mail/search`,
        {
            range: dates.val(),
            mail_id: id_mail
        },
        null,
        function (result) {
            let log_mail = result.log_mail;

            $('.timeline-view').html(``);
            $.each(log_mail, function (key, val) {
                let iframe = `
                        <iframe 
                        class="preview-height preview-width no-padding no-margin" 
                        id="iframe" 
                        src="mail/timeline/${val.id}/${api_key}/${val.mail_id}">
                            Loading...
                        </iframe>
                    `;

                let templates = $.parseHTML(timeline_card);
                $('.timeline-sequence', templates).html(val.id);
                $('.timeline-sent_at', templates).html(val.sent_at);
                $('.timeline-processing_time', templates).html(val.processing_time);
                $('.timeline-preview', templates).html(iframe);
                $('.timeline-result_data', templates).html(val.result_data);
                $('.timeline-debug_info', templates).html(val.debug_info);

                $('.timeline-view').append(templates);
            });

            if (log_mail.length === 0) {
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
