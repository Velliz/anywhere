$(function () {

    let id_mail = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();
    let email = $('input[name=email]').val();

    let table = $('#table').DataTable({
        ajax: {
            type: "POST",
            dataType: "json",
            responsive: true,
            url: "digital_signs/table",
            data: function (data) {
                data.email = email;
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
            }
        ],
        language: datatables_config,
        rowCallback: function (row, data) {
            $('td:eq(0)', row).html(data[8]);
            $('td:eq(1)', row).html(data[2]);
            $('td:eq(2)', row).html(data[3]);
            $('td:eq(3)', row).html(data[5]);
            $('td:eq(4)', row).html(data[6]);
            $('td:eq(5)', row).html(data[7]);
        },
        fnDrawCallback: function () {
        },
        preDrawCallback: function (settings) {
        }
    });

});
