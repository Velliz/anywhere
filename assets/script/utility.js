$(function () {
    let authorization = localStorage.getItem('bearer');
    if (authorization === undefined) {
        return false;
    }
    if (authorization === null) {
        return false;
    }
    if (authorization.length === 0) {
        return false;
    }

    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${authorization}`);
        }
    });
});

function ajax_post(url, data, table, success, error) {
    if (success === undefined) {
        success = function () {
            pnotify('Berhasil', 'Permintaan anda berhasil diproses.', 'info');
            if (table !== null) {
                table.ajax.reload();
            }
        };
    }
    if (error === undefined) {
        error = function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            if (jqXHR.responseJSON !== undefined) {
                pnotify(errorThrown, jqXHR.responseJSON.exception.Message, 'error');
            } else {
                pnotify(errorThrown, 'Gagal terhubung ke server', 'error');
            }
        };
    }

    $.ajax({
        url: url,
        data: JSON.stringify(data),
        dataType: 'json',
        type: 'POST',
        success: success,
        error: error,
    });
}

function ajax_put(url, data, table, success, error) {
    if (success === undefined) {
        success = function () {
            pnotify('Berhasil', 'Permintaan anda berhasil diproses.', 'info');
            if (table !== null) {
                table.ajax.reload();
            }
        };
    }
    if (error === undefined) {
        error = function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            if (jqXHR.responseJSON !== undefined) {
                pnotify(errorThrown, jqXHR.responseJSON.exception.Message, 'error');
            } else {
                pnotify(errorThrown, 'Gagal terhubung ke server', 'error');
            }
        };
    }

    $.ajax({
        url: url,
        data: JSON.stringify(data),
        dataType: 'json',
        type: 'PUT',
        success: success,
        error: error,
    });
}

function ajax_get(url, table, success, error) {
    if (success === undefined) {
        success = function () {
            pnotify('Berhasil', 'Permintaan anda berhasil diproses.', 'info');
            if (table !== null) {
                table.ajax.reload();
            }
        };
    }
    if (error === undefined) {
        error = function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            if (jqXHR.responseJSON !== undefined) {
                pnotify(errorThrown, jqXHR.responseJSON.exception.Message, 'error');
            } else {
                pnotify(errorThrown, 'Gagal terhubung ke server', 'error');
            }
        };
    }

    $.ajax({
        url: url,
        dataType: 'json',
        type: 'GET',
        success: success,
        error: error,
    });
}

function ajax_delete(url, table, success, error) {
    if (success === undefined) {
        success = function () {
            pnotify('Berhasil', 'Permintaan anda berhasil diproses.', 'info');
            if (table !== null) {
                table.ajax.reload();
            }
        };
    }
    if (error === undefined) {
        error = function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            if (jqXHR.responseJSON !== undefined) {
                pnotify(errorThrown, jqXHR.responseJSON.exception.Message, 'error');
            } else {
                pnotify(errorThrown, 'Gagal terhubung ke server', 'error');
            }
        };
    }

    $.ajax({
        url: url,
        dataType: 'json',
        type: 'DELETE',
        success: success,
        error: error,
    });
}

const datatables_config = {
    'buttons': {
        'pageLength': 'Show %d data'
    },
    'decimal': '',
    'emptyTable': 'No data founds',
    'info': 'Result _START_ to _END_ from _TOTAL_ templates',
    'infoEmpty': 'Result 0 to 0 from 0 row',
    'infoFiltered': '(Filtered from _MAX_ rows)',
    'infoPostFix': '',
    'thousands': ',',
    'lengthMenu': 'Show data _MENU_',
    'loadingRecords': 'Retrieving data...',
    'processing': 'Processing data...',
    'search': 'Filter:',
    'zeroRecords': 'Search result not found',
    'paginate': {
        'first': 'First',
        'last': 'Last',
        'next': 'Next',
        'previous': 'Prev.'
    },
    'aria': {
        'sortAscending': ': pilih untuk mengurutkan kecil ke besar',
        'sortDescending': ': pilih untuk mengurutkan besar ke kecil'
    }
};

const datatables_menu = [
    [10, 50, 100, 200],
    ['10', '50', '100', '200']
];

function bootbox_dialog(title, message, size, ok_action, cancel_action, with_btn = true) {
    let btn = null;
    if (with_btn) {
        btn = {
            cancel: {
                label: "Batal",
                className: 'btn-default btn-sm',
                callback: cancel_action
            },
            ok: {
                label: "Lanjut",
                className: 'btn-primary btn-sm',
                callback: ok_action
            }
        };
    }
    return bootbox.dialog({
        title: title,
        message: message,
        size: size,
        buttons: btn
    });
}

function pnotify(title, text, type) {
    new PNotify({
        title: title,
        text: text,
        type: type,
        styling: 'bootstrap3',
        mobile: {
            swipe_dismiss: true,
            styling: true
        },
        buttons: {
            closer: true,
            sticker: false,
            closer_hover: true,
            show_on_nonblock: true
        }
    });
}
