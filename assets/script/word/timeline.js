$(function () {

    let id_word = $('input[name=id]').val();
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
            `log_word/search`,
            {
                range: dates.val(),
                word_id: id_word
            },
            null,
            function (result) {
                let log_word = result.log_word;

                $('.timeline-view').html(``);
                $.each(log_word, function (key, val) {

                    //$logID, $api_key, $wordId

                    let iframe = `
                        <iframe 
                        class="preview-height preview-width no-padding no-margin" 
                        id="iframe" 
                        src="word/timeline/${val.id}/${api_key}/${val.word_id}">
                            Loading...
                        </iframe>
                    `;

                    let templates = $.parseHTML(timeline_card);
                    $('.timeline-sequence', templates).html(val.id);
                    $('.timeline-sent_at', templates).html(val.sent_at);
                    $('.timeline-processing_time', templates).html(val.processing_time);
                    $('.timeline-preview', templates).html(iframe);

                    $('.timeline-view').append(templates);
                });

                if (log_word.length === 0) {
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
