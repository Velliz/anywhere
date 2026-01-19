$(function() {

    let id_mail = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let css;
    let editor;
    let timeout;

    ajax_get(
        `mail/${id_mail}`,
        null,
        function (result) {
            NProgress.done();

            let mail = result.mail;

            css = $(`textarea[name=code]`).val(mail.css);
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
                src="mail/coderender/${api_key}/${id_mail}">
                    Loading...
                </iframe>
            `);

            editor.on('change', function () {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    ajax_post(
                        `mail/${id_mail}/update/style`,
                        {
                            css: editor.getValue()
                        },
                        null,
                        function (result) {
                            let mail = result.mail;
                            pnotify(`Reloading Mail`, `CSS saved!`, 'success');
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
            NProgress.done();

            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );

});
