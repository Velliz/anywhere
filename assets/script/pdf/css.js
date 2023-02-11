$(function () {

    let id_pdf = $('input[name=id]').val();

    let css;
    let editor;
    let timeout;

    ajax_get(
        `pdf/${id_pdf}`,
        null,
        function (result) {
            let pdf = result.pdf;

            css = $(`textarea[name=code]`).val(pdf.css);
            editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                lineNumbers: true,
                name: "css",
                mode: "css",
                extraKeys: {
                    "F11": function (cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    },
                    "Esc": function (cm) {
                        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    }
                }
            });

            $('.iframe').html(`
                <iframe 
                class="full-height full-width no-padding no-margin" 
                id="iframe" 
                src="pdf/coderender/06cfa92d19ddbd70cb368116e23a1922/${id_pdf}">
                    Loading...
                </iframe>
            `);

            editor.on('change', function () {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    ajax_post(
                        `pdf/${id_pdf}/update/style`,
                        {
                            css: editor.getValue()
                        },
                        null,
                        function (result) {
                            let pdf = result.pdf;
                            pnotify(`Reloading PDF`, `CSS saved!`, 'success');
                            document.getElementById('iframe').contentDocument.location.reload();
                        },
                        function (xhr, error) {
                            if (error === 'error') {
                                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                            }
                        }
                    );
                }, 2200);
            });
        },
        function (xhr, error) {
            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );
});
