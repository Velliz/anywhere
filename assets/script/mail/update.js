$(function () {

    let id_mail = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let mailname;
    let host;
    let port;
    let mailaddress;
    let mailpassword;
    let requesttype;
    let requesturl;
    let smtpauth;
    let smtpsecure;
    let cssexternal;
    let requestsample;

    let requestsample_editor;
    let cssexternal_editor;

    ajax_get(
        `mail/${id_mail}`,
        null,
        function (result) {
            let mail = result.mail;

            mailname = $('input[name=mailname]').val(mail.mail_name);
            host = $('input[name=host]').val(mail.host);
            port = $('input[name=port]').val(mail.port);
            mailaddress = $('input[name=mailaddress]').val(mail.mail_address);
            mailpassword = $('input[name=mailpassword]').val(mail.mail_password);
            requesttype = $(`input[name=requesttype][value="${mail.request_type}"]`).prop("checked", true);
            requesturl = $(`input[name=requesturl]`).val(mail.request_url);
            smtpauth = $(`select[name=smtpauth]`).val(mail.smtp_auth);
            smtpsecure = $(`select[name=smtpsecure]`).val(mail.smtp_secure);
            cssexternal = $(`textarea[name=cssexternal]`).val(mail.css_external);
            requestsample = $(`textarea[name=requestsample]`).val(mail.request_sample);

            cssexternal_editor = CodeMirror.fromTextArea(document.getElementById("cssexternal"), {
                lineNumbers: true,
                theme: "night",
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
        },
        function (xhr, error) {
            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );

    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `mail/${id_mail}/update`,
            {
                mail_name: mailname.val(),
                host: host.val(),
                port: port.val(),
                mail_address: mailaddress.val(),
                mail_password: mailpassword.val(),
                request_type: $(`input[name=requesttype]:checked`).val(),
                request_url: requesturl.val(),
                smtp_auth: smtpauth.val(),
                smtp_secure: smtpsecure.val(),

                css_external: cssexternal_editor.getValue(),
                request_sample: requestsample_editor.getValue(),
            },
            null,
            function (result) {
                let mail = result.mail;
                pnotify(`Template updated`, `New template "${mail.mail_name}" successfully updated!`, 'success');

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
