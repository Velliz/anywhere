$(function () {

    let id_pdf = $('input[name=id]').val();

    ajax_get(
        `pdf/${id_pdf}`,
        null,
        function (result) {
            let pdf = result.pdf;

            $(`textarea[name=code]`).val(pdf.html);

            let editor = CodeMirror.fromTextArea(document.getElementById("code"), {
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

            editor.on("change", function (cm, change) {
                pnotify(`Template error`, 'Saving....', 'error');
            });
            $('.iframe').html(`<iframe id="iframe" src="pdf/coderender/06cfa92d19ddbd70cb368116e23a1922/${id_pdf}" frameborder="0" style="overflow:hidden;height:100%;width:100%">
                Loading...
            </iframe>`);

        },
        function (xhr, error) {
            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );

    $('a[name=save-btn]').on('click', function () {
        $('form[name=save]').submit();
    });


});
