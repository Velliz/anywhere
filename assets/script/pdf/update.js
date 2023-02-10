$(function() {

    let id_pdf = $('input[name=id]').val();

    let reportname;
    let paper;
    let requesttype;
    let orientation;
    let requesturl;
    let outputmode;

    let cssexternal;
    let requestsample;
    let phpscript;

    ajax_get(
        `pdf/${id_pdf}`,
        null,
        function (result) {
            let pdf = result.pdf;

            reportname = $(`input[name=reportname]`).val(pdf.report_name);
            paper = $(`input[name=paper][value="${pdf.paper}"]`).prop("checked", true);
            requesttype = $(`input[name=requesttype][value="${pdf.request_type}"]`).prop("checked", true);
            orientation = $(`input[name=orientation][value="${pdf.orientation}"]`).prop("checked", true);
            requesturl = $(`input[name=requesturl]`).val(pdf.request_url);
            outputmode = $(`input[name=outputmode][value="${pdf.output_mode}"]`).prop("checked", true);

            cssexternal = $(`textarea[name=cssexternal]`).val(pdf.css_external);
            requestsample = $(`textarea[name=requestsample]`).val(pdf.request_sample);
            phpscript = $(`textarea[name=phpscript]`).val(pdf.php_script);

            CodeMirror.fromTextArea(document.getElementById("requestsample"), {
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

            CodeMirror.fromTextArea(document.getElementById("cssexternal"), {
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

            CodeMirror.fromTextArea(document.getElementById("phpscript"), {
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
        }
    );

    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `pdf/${id_pdf}/update`,
            {
                report_name: reportname.val(),
                paper: paper.val(),
                request_type: requesttype.val(),
                orientation: orientation.val(),
                request_url: requesturl.val(),
                output_mode: outputmode.val(),
                css_external: cssexternal.val(),
                request_sample: requestsample.val(),
                php_script: phpscript.val(),
            },
            null,
            function (result) {
                let pdf = result.pdf;
                pnotify(`Template updated`, `"New template ${pdf.report_name}" successfully updated!`, 'success');

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
