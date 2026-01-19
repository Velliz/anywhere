$(function () {

    let id_word = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let word_name;
    let request_sample;

    let requestsample_editor;

    let word_template = $('input[name=word_template]');

    ajax_get(
        `word/${id_word}`,
        null,
        function (result) {
            NProgress.done();

            let word = result.word;

            word_name = $(`input[name=word_name]`).val(word.word_name);
            request_sample = $(`textarea[name=request_sample]`).val(word.request_sample);

            requestsample_editor = CodeMirror.fromTextArea(document.getElementById("request_sample"), {
                lineNumbers: true,
                name: "javascript",
                mode: "javascript",
                extraKeys: {
                    "F11": function (cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    },
                    "Esc": function (cm) {
                        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    }
                }
            });

            word_template.change(function (e) {
                e.preventDefault();
                waitingDialog.show('Processing document');

                let filedata = $('input[name=word_template]').prop("files")[0];
                let formdata = new FormData();

                formdata.append('word_template', filedata);

                $.ajax({
                    url: `word/${id_word}/update/template`,
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formdata,
                    error: function (error) {
                        waitingDialog.hide();
                        pnotify(`Template error`, error.responseJSON.exception.message, 'error');
                    },
                    success: function (data) {
                        waitingDialog.hide();
                        pnotify(`Template updated`, `New template successfully updated!`, 'success');
                        word_template.val('');
                    }
                });
            });
        },
        function (xhr, error) {
            NProgress.done();

            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );

    // save upload file


    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `word/${id_word}/update`,
            {
                word_name: word_name.val(),
                request_sample: requestsample_editor.getValue(),
            },
            null,
            function (result) {
                NProgress.done();

                let word = result.word;
                pnotify(`Template updated`, `New template "${word.report_name}" successfully updated!`, 'success');

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
