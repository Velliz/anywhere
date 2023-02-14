$(function () {

    let pdf_table = $('#pdf-table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "pdf/table",
            data: function (data) {
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
            dataSrc: function (json) {
                if (json.exception !== undefined) {
                    return [];
                }
                return json.data;
            }
        },
        processing: true,
        serverSide: true,
        stateSave: true,
        bAutoWidth: false,
        dom: 'Bfrtip',
        lengthMenu: datatables_menu,
        buttons: [
            {
                extend: "pageLength",
                className: "btn-sm"
            },
            {
                className: "btn-sm btn-primary",
                text: `Create new template`,
                action: function () {
                    bootbox_dialog(
                        `Template name`,
                        `<input class="form-control" name="report_name" placeholder="pdf template name"/>`,
                        `small`,
                        function () {
                            $('.bootbox-accept').prop('disabled', true);
                            let report_name = $('.bootbox-body input[name=report_name]').val();
                            ajax_post(
                                `pdf/create`,
                                {
                                    report_name: report_name
                                },
                                pdf_table,
                                function (result) {
                                    pdf_table.ajax.reload();

                                    let pdf = result.pdf;
                                    pnotify(`Template created`, `New template ${report_name} - ${pdf.paper} ${pdf.orientation} successfully created!`, 'success');
                                    bootbox.hideAll();
                                },
                                function (xhr, error) {
                                    $('.bootbox-accept').prop('disabled', false);
                                    if (error === 'error') {
                                        pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                                    }
                                }
                            );
                            return false;
                        }
                    );
                }
            },
        ],
        language: datatables_config,
        rowCallback: function (row, data) {
            let details = `<a title="Details" href="pdf/update/${data[0]}" target="_blank" class="btn btn-xs btn-primary">
                <i class="fa fa-eye"></i> Details
            </a>`;
            let designer = `<a title="Designer" href="pdf/html/${data[0]}" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px">
                <i class="fa fa-pencil"></i> Designer
            </a>`;
            let usages = `<a title="Usage History" href="pdf/timeline/${data[0]}" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px">
                <i class="fa fa-external-link"></i> Usage History
            </a>`;

            $('td:eq(0)', row).html(`<b>${data[2]}</b>`);
            $('td:eq(1)', row).html(`<span class="label label-danger">${data[7]}</span>`);
            $('td:eq(2)', row).html(data[8]);
            $('td:eq(3)', row).html(details + designer + usages);
        },
        fnDrawCallback: function () {
        },
        preDrawCallback: function (settings) {
        }
    });

    let excel_table = $('#excel-table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "excel/table",
            data: function (data) {
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
            dataSrc: function (json) {
                if (json.exception !== undefined) {
                    return [];
                }
                return json.data;
            }
        },
        processing: true,
        serverSide: true,
        stateSave: true,
        bAutoWidth: false,
        dom: 'Bfrtip',
        lengthMenu: datatables_menu,
        buttons: [
            {
                extend: "pageLength",
                className: "btn-sm"
            },
            {
                className: "btn-sm btn-primary",
                text: `Create new template`,
                action: function () {
                    bootbox_dialog(
                        `Template name`,
                        `<input class="form-control" name="report_name" placeholder="excel template name"/>`,
                        `small`,
                        function () {
                            $('.bootbox-accept').prop('disabled', true);
                            let report_name = $('.bootbox-body input[name=report_name]').val();
                            ajax_post(
                                `excel/create`,
                                {
                                    excel_name: report_name
                                },
                                excel_table,
                                function (result) {
                                    excel_table.ajax.reload();

                                    let excel = result.excel;
                                    pnotify(`Template created`, `New template ${report_name} successfully created!`, 'success');
                                    bootbox.hideAll();
                                },
                                function (xhr, error) {
                                    $('.bootbox-accept').prop('disabled', false);
                                    if (error === 'error') {
                                        pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                                    }
                                }
                            );
                            return false;
                        }
                    );
                }
            },
        ],
        language: datatables_config,
        rowCallback: function (row, data) {
            let details = `<a title="Details" href="excel/update/${data[0]}" target="_blank" class="btn btn-xs btn-primary">
                <i class="fa fa-eye"></i> Details
            </a>`;
            let usages = `<a title="Usage History" href="excel/timeline/${data[0]}" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px">
                <i class="fa fa-external-link"></i> Usage History
            </a>`;

            $('td:eq(0)', row).html(`<b>${data[2]}</b>`);
            $('td:eq(1)', row).html(`<span class="label label-danger">${data[5]}</span>`);
            $('td:eq(2)', row).html(details + usages);
        },
        fnDrawCallback: function () {
        },
        preDrawCallback: function (settings) {
        }
    });

    /*
    $('#mail-table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        stateSave: true,
        lengthMenu: menu,
        buttons: [
            {
                extend: "pageLength",
                className: "btn-sm"
            },
            {
                className: "btn-sm btn-primary",
                text: '<i class="fa fa-plus"></i>',
                action: function () {
                    window.location.href = "mail/main";
                }
            },
        ],
        language: lang,
    });

    $('#image-table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        stateSave: true,
        lengthMenu: menu,
        buttons: [
            {
                extend: "pageLength",
                className: "btn-sm"
            },
            {
                className: "btn-sm btn-primary",
                text: '<i class="fa fa-plus"></i>',
                action: function () {
                    window.location.href = "images/main";
                }
            },
        ],
        language: lang,
    });

    $('#var-table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        stateSave: true,
        lengthMenu: menu,
        buttons: [
            {
                extend: "pageLength",
                className: "btn-sm"
            },
            {
                className: "btn-sm btn-primary",
                text: '<i class="fa fa-plus"></i>',
                action: function () {
                    let content = addVar;
                    bootbox.dialog({
                        title: `Variabel baru`,
                        message: content,
                    });
                }
            },
        ],
        language: lang,
    });

    $('#digitalsign-table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        stateSave: true,
        lengthMenu: menu,
        buttons: [
            {
                extend: "pageLength",
                className: "btn-sm"
            },
            {
                className: "btn-sm btn-primary",
                text: '<i class="fa fa-plus"></i>',
                action: function () {
                    //todo: add new users digitalsigns

                }
            },
        ],
        language: lang,
    });

    $(document).on('click', '.btn-digitalsign-history', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        let dial = bootbox.dialog({
            title: 'Histori Digital Sign',
            message: digitalsigns_forms,
            size: 'large',
        });
        dial.init(function () {

        });
    });

    $(document).on('click', '.btn-digitalsign-users', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        let dial = bootbox.dialog({
            title: 'Data Detail Penandatangan',
            message: digitalsigns_forms,
            size: 'large',
        });
        dial.init(function () {

        });
    });
    */
});
