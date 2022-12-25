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
    $.ajax({
        url: url,
        dataType: 'json',
        type: 'GET',
        success: success,
        error: error,
    });
}

function ajax_delete(url, table, success, error) {
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
    'info': 'Result _START_ to _END_ from _TOTAL_ rows',
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
    [50, 100, 200],
    ['50', '100', '200']
];
