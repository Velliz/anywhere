$(function () {

    let id_pdf = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let reportname;
    let paper;
    let requesttype;
    let orientation;
    let requesturl;
    let outputmode;

    let cssexternal;
    let requestsample;
    let phpscript;

    let requestsample_editor;
    let cssexternal_editor;
    let phpscript_editor;

    ajax_get(
        `pdf/${id_pdf}`,
        null,
        function (result) {
            NProgress.done();

            let pdf = result.pdf;

            reportname = $(`input[name=reportname]`).val(pdf.report_name);
            paper = $(`input[name=paper]`).val(pdf.paper);
            requesttype = $(`input[name=requesttype][value="${pdf.request_type}"]`).prop("checked", true);
            orientation = $(`input[name=orientation][value="${pdf.orientation}"]`).prop("checked", true);
            requesturl = $(`input[name=requesturl]`).val(pdf.request_url);
            outputmode = $(`input[name=outputmode][value="${pdf.output_mode}"]`).prop("checked", true);

            cssexternal = $(`textarea[name=cssexternal]`).val(pdf.css_external);
            requestsample = $(`textarea[name=requestsample]`).val(pdf.request_sample);
            phpscript = $(`textarea[name=phpscript]`).val(pdf.php_script);

            requestsample_editor = CodeMirror.fromTextArea(document.getElementById("requestsample"), {
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

            cssexternal_editor = CodeMirror.fromTextArea(document.getElementById("cssexternal"), {
                lineNumbers: true,
                name: "htmlmixed",
                mode: "htmlmixed",
                extraKeys: {
                    "F11": function (cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    },
                    "Esc": function (cm) {
                        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    }
                }
            });

            phpscript_editor = CodeMirror.fromTextArea(document.getElementById("phpscript"), {
                lineNumbers: true,
                name: "php",
                mode: "text/x-php",
                extraKeys: {
                    "F11": function (cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    },
                    "Esc": function (cm) {
                        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    }
                }
            });
        },
        function (xhr, error) {
            NProgress.done();

            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );

    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `pdf/${id_pdf}/update`,
            {
                report_name: reportname.val(),
                paper: $(`input[name=paper]`).val(),
                request_type: $(`input[name=requesttype]:checked`).val(),
                orientation: $(`input[name=orientation]:checked`).val(),
                request_url: requesturl.val(),
                output_mode: $(`input[name=outputmode]:checked`).val(),
                css_external: cssexternal_editor.getValue(),
                request_sample: requestsample_editor.getValue(),
                php_script: phpscript_editor.getValue(),
            },
            null,
            function (result) {
                NProgress.done();

                let pdf = result.pdf;
                pnotify(`Template updated`, `New template "${pdf.report_name}" successfully updated!`, 'success');

                btn_submit.prop('disabled', false);
                btn_submit.html('Simpan Konfigurasi');
            },
            function (xhr, error) {
                NProgress.done();

                if (error === 'error') {
                    pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                }

                btn_submit.prop('disabled', false);
                btn_submit.html('Simpan Konfigurasi');
            }
        );
    });

});
