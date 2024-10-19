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

    let image_table = $('#image-table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "images/table",
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
                        `<input class="form-control" name="report_name" placeholder="image template name"/>`,
                        `small`,
                        function () {
                            $('.bootbox-accept').prop('disabled', true);
                            let report_name = $('.bootbox-body input[name=report_name]').val();
                            ajax_post(
                                `images/create`,
                                {
                                    image_name: report_name,
                                    request_type: "POST",
                                    request_url: ""
                                },
                                image_table,
                                function (result) {
                                    image_table.ajax.reload();

                                    let images = result.images;
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
            let details = `<a title="Details" href="images/update/${data[0]}" target="_blank" class="btn btn-xs btn-primary">
                <i class="fa fa-eye"></i> Details
            </a>`;
            let usages = `<a title="Usage History" href="images/timeline/${data[0]}" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px">
                <i class="fa fa-external-link"></i> Usage History
            </a>`;

            $('td:eq(0)', row).html(`<b>${data[2]}</b>`);
            $('td:eq(1)', row).html(data[3]);
            $('td:eq(2)', row).html(data[10]);
            $('td:eq(3)', row).html(`${parseInt(data[4])}, ${parseInt(data[5])}, ${parseInt(data[6])}, ${parseInt(data[7])}, ${parseInt(data[8])}, ${parseInt(data[9])}`);
            $('td:eq(4)', row).html(details + usages);
        },
        fnDrawCallback: function () {
        },
        preDrawCallback: function (settings) {
        }
    });

    let var_table = $('#var-table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "constanta/table",
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
                text: `Create new variable`,
                action: function () {
                    bootbox_dialog(
                        `Create new variable`,
                        `<div class="form">
                            <div class="form-group">
                                <input class="form-control" name="variable_key" placeholder="Key"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="variable_name" placeholder="Val"/>
                            </div>
                        </div>`,
                        `small`,
                        function () {
                            $('.bootbox-accept').prop('disabled', true);
                            let variable_key = $('.bootbox-body input[name=variable_key]').val();
                            let variable_name = $('.bootbox-body input[name=variable_name]').val();
                            ajax_post(
                                `constanta/create`,
                                {
                                    unique_key: variable_key,
                                    constanta_val: variable_name
                                },
                                var_table,
                                function (result) {
                                    var_table.ajax.reload();

                                    let constanta = result.constanta;
                                    pnotify(`Template created`, `New variable ${variable_key} successfully created!`, 'success');
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
            let details = `<div class="form-group">
                <input readonly="readonly" type="text" class="form-control" name="key" placeholder="key" value="${data[2]}"/>
                <textarea name="val" class="form-control" placeholder="values" cols="70" rows="1">${data[3]}</textarea>
                <button type="submit" class="btn btn-primary btn-sm btn-update-variable" data-id="${data[0]}">
                    <i class="fa fa-refresh"></i>
                </button>
            </div>`;
            $('td:eq(0)', row).html(details);
        },
        fnDrawCallback: function () {
            $('.btn-update-variable').on('click', function () {
                let id = $(this).attr('data-id');
                let variable_key = $(this).parent().find('input').val();
                let variable_name = $(this).parent().find('textarea').val();
                ajax_post(
                    `constanta/${id}/update`,
                    {
                        unique_key: variable_key,
                        constanta_val: variable_name
                    },
                    var_table,
                    function (result) {
                        let constanta = result.constanta;
                        pnotify(`Template created`, `New variable ${variable_key} successfully created!`, 'success');
                    },
                    function (xhr, error) {
                        if (error === 'error') {
                            pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                        }
                    }
                );
            });
        },
        preDrawCallback: function (settings) {
        }
    });

    let digitalsign_table = $('#digitalsign-table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "digital_sign_users/table",
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
                text: `Create new`,
                action: function () {
                    bootbox_dialog(
                        `Create new digital sign user`,
                        `<div class="form">
                                <div class="form-group">
                                    <input class="form-control" name="name" placeholder="Name"/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="email" placeholder="Email"/>
                                </div>
                            </div>
                        </div>`,
                        `small`,
                        function () {
                            $('.bootbox-accept').prop('disabled', true);
                            let name = $('.bootbox-body input[name=name]').val();
                            let email = $('.bootbox-body input[name=email]').val();
                            ajax_post(
                                `digital_sign_users/create`,
                                {
                                    name: name,
                                    email: email
                                },
                                digitalsign_table,
                                function (result) {
                                    digitalsign_table.ajax.reload();

                                    let digital_sign_users = result.digital_sign_users;
                                    pnotify(`Template created`, `New sign user ${name} successfully created!`, 'success');
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
            let details = `<a title="Details" href="digitalsigns/users/${data[0]}" target="_blank" class="btn btn-xs btn-primary">
                <i class="fa fa-eye"></i> Details
            </a>`;
            let history = `<a title="Sign History" href="digitalsigns/timeline/${data[0]}" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px">
                <i class="fa fa-external-link"></i> Usage History
            </a>`;
            $('td:eq(0)', row).html(`<b>${data[2]}</b>`);
            $('td:eq(1)', row).html(data[4]);
            $('td:eq(2)', row).html(data[5]);
            $('td:eq(3)', row).html(data[11]);
            $('td:eq(4)', row).html(data[14]);
            $('td:eq(5)', row).html(data[15]);
            $('td:eq(6)', row).html(data[16]);
            $('td:eq(7)', row).html(details + history);
        },
        fnDrawCallback: function () {
        },
        preDrawCallback: function (settings) {
        }
    });

    let mail_table = $('#mail-table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "mail/table",
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
                text: `Create new`,
                action: function () {
                    bootbox_dialog(
                        `Create new email`,
                        `<div class="form">
                            <div class="form-group">
                                <input class="form-control" name="mail_name" placeholder="Nama Email"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="mail_address" placeholder="xxx@gmail.com"/>
                            </div>
                        </div>`,
                        `small`,
                        function () {
                            $('.bootbox-accept').prop('disabled', true);
                            let mail_name = $('.bootbox-body input[name=mail_name]').val();
                            let mail_address = $('.bootbox-body input[name=mail_address]').val();
                            ajax_post(
                                `mail/create`,
                                {
                                    mail_name: mail_name,
                                    mail_address: mail_address
                                },
                                mail_table,
                                function (result) {
                                    mail_table.ajax.reload();

                                    let constanta = result.constanta;
                                    pnotify(`Template created`, `New mail "${mail_name}" successfully created!`, 'success');
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
            let details = `<a title="Details" href="mail/update/${data[0]}" target="_blank" class="btn btn-xs btn-primary">
                <i class="fa fa-eye"></i> Details
            </a>`;
            let history = `<a title="Mail History" href="mail/timeline/${data[0]}" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px">
                <i class="fa fa-external-link"></i> Usage History
            </a>`;
            let send_mail_test = `<a title="Test Kirim Email" class="btn btn-xs btn-danger send_mail_test" style="margin-left: 10px" data-id="${data[0]}">
                <i class="fa fa-reply"></i> Test Kirim Email
            </a>`;
            $('td:eq(0)', row).html(`<b>${data[4]}</b>`);
            $('td:eq(1)', row).html(data[5]);
            $('td:eq(2)', row).html(data[10]);
            $('td:eq(3)', row).html(details + history + send_mail_test);
        },
        fnDrawCallback: function () {
            $('.send_mail_test').on('click', function () {
                let id = $(this).attr('data-id');
                let test_form = `<div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email Tujuan" value="">
                </div>`;

                let send_action = function () {
                    let mail = $('.bootbox-body input[name=email]').val();
                    let payload = {
                        mail: mail
                    };
                    ajax_post(`mail/sendtest/${id}`, payload, null, function (data) {
                        pnotify("Test Send Mail", data.Message, 'error');
                    });
                }
                bootbox_dialog(`Testing Kirim Email`, test_form, `medium`, send_action);

            });
        },
        preDrawCallback: function (settings) {
        }
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

});
