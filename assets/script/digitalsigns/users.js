$(function() {

    let id_digitalsign_users = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let name = $('input[name=dsu-name]');
    let phone = $('input[name=dsu-phone]');

    let btn_submit = $('button[name=submit]').on('click', function () {
        btn_submit.prop('disabled', true);
        btn_submit.html('Menyimpan...');
        ajax_post(
            `digital_sign_users/${id_digitalsign_users}/update`,
            {
                name: name.val(),
                phone: phone.val(),
            },
            null,
            function (result) {
                let digital_sign_users = result.digital_sign_users;
                pnotify(`Template updated`, `"New template ${digital_sign_users.name}" successfully updated!`, 'success');

                btn_submit.prop('disabled', false);
                btn_submit.html('Update Data');
            },
            function (xhr, error) {
                if (error === 'error') {
                    pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
                }

                btn_submit.prop('disabled', false);
                btn_submit.html('Update Data');
            }
        );
    });

});
