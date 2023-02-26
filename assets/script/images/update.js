$(document).ready(function () {

    let image_id = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let placeholder_file = $('input[name=placeholderfile]');
    let placeholder_holder = $('.placeholder_holder');

    let sample_file = $('input[name=samplefile]');
    let sample_holder = $('.sample_holder');

    let imagename;
    let requesttype;
    let requesturl;

    let x;
    let y;
    let x2;
    let y2;
    let w;
    let h;

    ajax_get(
        `images/${image_id}`,
        null,
        function (result) {
            let images = result.images;

            imagename = $('input[name=imagename]').val(images.image_name);
            requesttype = $(`input[name=requesttype][value="${images.request_type}"]`).prop("checked", true);
            requesturl = $('input[name=requesturl]').val(images.request_url);

            x = $('#crop_x').val(images.x);
            y = $('#crop_y').val(images.y);
            x2 = $('#crop_x2').val(images.x2);
            y2 = $('#crop_y2').val(images.y2);
            w = $('#crop_w').val(images.w);
            h = $('#crop_h').val(images.h);

            placeholder_file.change(function (e) {
                e.preventDefault();
                waitingDialog.show('Processing Images');

                let filedata = $('input[name=placeholderfile]').prop("files")[0];
                let formdata = new FormData();

                formdata.append('placeholderfile', filedata);
                formdata.append('type', 'placeholder');
                formdata.append('id', image_id);

                $.ajax({
                    url: 'api/placeholder',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formdata,
                    error: function (error) {
                        location.reload();
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            sample_file.change(function (e) {
                e.preventDefault();
                waitingDialog.show('Processing Images');

                let filedata = $('input[name=samplefile]').prop("files")[0];
                let formdata = new FormData();

                formdata.append('samplefile', filedata);
                formdata.append('type', 'sample');
                formdata.append('id', image_id);

                $.ajax({
                    url: 'api/placeholder',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formdata,
                    error: function (error) {
                        location.reload();
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            $('#imagetarget').Jcrop({
                onSelect: showCoords,
                setSelect: [images.x, images.y, images.x2, images.y2],
                bgColor: 'black',
                bgOpacity: 0.3,
            });

        },
        function (xhr, error) {
        if (error === 'error') {
            pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
        }
    });

    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `images/${image_id}/update`,
            {
                image_name: imagename.val(),
                request_type: $(`input[name=requesttype]:checked`).val(),
                request_url: requesturl.val(),
                x: x.val(),
                y: y.val(),
                x2: x2.val(),
                y2: y2.val(),
                w: w.val(),
                h: h.val(),
            },
            null,
            function (result) {
                let images = result.images;
                pnotify(`Template updated`, `"New template ${images.image_name}" successfully updated!`, 'success');

                btn_submit.prop('disabled', false);
                btn_submit.html('Simpan Konfigurasi');
            },
            function (xhr, error) {
                if (error === 'error') {
                    pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                }

                btn_submit.prop('disabled', false);
                btn_submit.html('Simpan Konfigurasi');
            }
        );
    });

});

function showCoords(c) {
    $('#crop_x').val(c.x);
    $('#crop_y').val(c.y);
    $('#crop_x2').val(c.x2);
    $('#crop_y2').val(c.y2);
    $('#crop_w').val(c.w);
    $('#crop_h').val(c.h);
}
