
var editor = CodeMirror.fromTextArea(document.getElementById("requestsample"), {
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
var external = CodeMirror.fromTextArea(document.getElementById("cssexternal"), {
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
var phpscript = CodeMirror.fromTextArea(document.getElementById("phpscript"), {
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
