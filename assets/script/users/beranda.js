$(function () {

    $('#pdf-table').DataTable({
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
                    window.location.href = "pdf/main";
                }
            },
        ],
        language: lang,
    });

    $('#xlsx-table').DataTable({
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
                    window.location.href = "excel/main";
                }
            },
        ],
        language: lang,
    });

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

});
