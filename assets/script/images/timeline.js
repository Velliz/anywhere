// place your custom JS script here
$(function () {

    let id_images = $('input[name=id]').val();
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
            `log_images/search`,
            {
                range: dates.val(),
                images_id: id_images
            },
            null,
            function (result) {
                let log_images = result.log_images;

                $('.timeline-view').html(``);
                $.each(log_images, function (key, val) {

                    //$logID, $api_key, $imagesId

                    let iframe = `<img 
                        class="preview-height preview-width no-padding no-margin" 
                        src="images/timeline/${val.id}/${api_key}/${val.images_id}"/>`;

                    let templates = $.parseHTML(timeline_card);
                    $('.timeline-sequence', templates).html(val.id);
                    $('.timeline-sent_at', templates).html(val.sent_at);
                    $('.timeline-processing_time', templates).html(val.processing_time);
                    $('.timeline-preview', templates).html(iframe);

                    $('.timeline-view').append(templates);
                });

                if (log_images.length === 0) {
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
