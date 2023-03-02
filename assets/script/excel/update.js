$(function() {

    let id_excel = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let excelname;
    let requesttype;
    let columnspecs;
    let dataspecs;

    let columnspecs_editor;
    let dataspecs_editor;

    let timeout1;
    let timeout2;

    ajax_get(
        `excel/${id_excel}`,
        null,
        function (result) {
            let excel = result.excel;

            excelname = $(`input[name=excelname]`).val(excel.excel_name);
            requesttype = $(`input[name=requesttype][value="${excel.request_type}"]`).prop("checked", true);

            columnspecs = $(`textarea[name=columnspecs]`).val(excel.column_specs);
            dataspecs = $(`textarea[name=dataspecs]`).val(excel.data_specs);

            columnspecs_editor = CodeMirror.fromTextArea(document.getElementById("columnspecs"), {
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

            dataspecs_editor = CodeMirror.fromTextArea(document.getElementById("dataspecs"), {
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

            columnspecs_editor.on('change', function () {
                clearTimeout(timeout1);
                timeout1 = setTimeout(function() {
                    ajax_post(
                        `excel/${id_excel}/update`,
                        {
                            excel_name: excelname.val(),
                            request_type: $(`input[name=requesttype]:checked`).val(),
                            column_specs: columnspecs_editor.getValue(),
                            data_specs: dataspecs_editor.getValue(),
                        },
                        null,
                        function (result) {
                            let excel = result.excel;
                            pnotify(`Template updated`, `"${excel.excel_name}" successfully updated!`, 'success');

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
                }, 2200);
            });

            dataspecs_editor.on('change', function () {
                clearTimeout(timeout2);
                timeout2 = setTimeout(function() {
                    ajax_post(
                        `excel/${id_excel}/update`,
                        {
                            excel_name: excelname.val(),
                            request_type: $(`input[name=requesttype]:checked`).val(),
                            column_specs: columnspecs_editor.getValue(),
                            data_specs: dataspecs_editor.getValue(),
                        },
                        null,
                        function (result) {
                            let excel = result.excel;
                            pnotify(`Template updated`, `"${excel.excel_name}" successfully updated!`, 'success');

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
                }, 2200);
            });
        }
    );

    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `excel/${id_excel}/update`,
            {
                excel_name: excelname.val(),
                request_type: $(`input[name=requesttype]:checked`).val(),
                column_specs: columnspecs_editor.getValue(),
                data_specs: dataspecs_editor.getValue(),
            },
            null,
            function (result) {
                let excel = result.excel;
                pnotify(`Template updated`, `"${excel.excel_name}" successfully updated!`, 'success');

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
