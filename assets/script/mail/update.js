$(function () {



    let smtpauth = $('select[name=smtpauth]');
    if (smtpauth.attr('data-item') != null) $(smtpauth).val(smtpauth.attr('data-item'));

    let smtpsecure = $('select[name=smtpsecure]');
    if (smtpsecure.attr('data-item') != null) $(smtpsecure).val(smtpsecure.attr('data-item'));

    let editor = CodeMirror.fromTextArea(document.getElementById("requestsample"), {
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
    let external = CodeMirror.fromTextArea(document.getElementById("cssexternal"), {
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
});
