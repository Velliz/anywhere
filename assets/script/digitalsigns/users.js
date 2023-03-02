$(function () {

    let id_digitalsign_users = $('input[name=id]').val();
    let api_key = $('input[name=api_key]').val();

    let name = $('input[name=dsu-name]');
    let phone = $('input[name=dsu-phone]');
    let email = $('input[name=dsu-email]');
    let type = $('select[name=dsu-type]');
    let ktp = $('input[name=dsu-ktp]');
    let npwp = $('input[name=dsu-npwp]');
    let address = $('input[name=dsu-address]');
    let city = $('input[name=dsu-city]');
    let province = $('input[name=dsu-province]');
    let gender = $('select[name=dsu-gender]');
    let place_of_birth = $('input[name=dsu-place_of_birth]');
    let date_of_birth = $('input[name=dsu-date_of_birth]');
    let org_unit = $('input[name=dsu-org_unit]');
    let work_unit = $('input[name=dsu-work_unit]');
    let position = $('input[name=dsu-position]');

    ajax_get(
        `digital_sign_users/${id_digitalsign_users}`,
        null,
        function (result) {
            let digital_sign_users = result.digital_sign_users;

            name.val(digital_sign_users.name);
            phone.val(digital_sign_users.phone);
            email.val(digital_sign_users.email);
            type.val(digital_sign_users.type);
            ktp.val(digital_sign_users.ktp);
            npwp.val(digital_sign_users.npwp);
            address.val(digital_sign_users.address);
            city.val(digital_sign_users.city);
            province.val(digital_sign_users.province);
            gender.val(digital_sign_users.gender);
            place_of_birth.val(digital_sign_users.place_of_birth);
            date_of_birth.val(digital_sign_users.date_of_birth).daterangepicker({
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10),
                singleDatePicker: true,
                locale: {
                    'format': 'DD/MM/YYYY'
                }
            });
            org_unit.val(digital_sign_users.org_unit);
            work_unit.val(digital_sign_users.work_unit);
            position.val(digital_sign_users.position);

            let btn_submit = $('button[name=submit]').on('click', function () {
                btn_submit.prop('disabled', true);
                btn_submit.html('Menyimpan...');
                ajax_post(
                    `digital_sign_users/${id_digitalsign_users}/update`,
                    {
                        name: name.val(),
                        phone: phone.val(),
                        email: email.val(),
                        type: type.val(),
                        ktp: ktp.val(),
                        npwp: npwp.val(),
                        address: address.val(),
                        city: city.val(),
                        province: province.val(),
                        gender: gender.val(),
                        place_of_birth: place_of_birth.val(),
                        date_of_birth: date_of_birth.val(),
                        org_unit: org_unit.val(),
                        work_unit: work_unit.val(),
                        position: position.val(),
                    },
                    null,
                    function (result) {
                        let digital_sign_users = result.digital_sign_users;
                        pnotify(`Sign updated`, `User sign "${digital_sign_users.name}" successfully updated!`, 'success');

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

        },
        function (xhr, error) {
            if (error === 'error') {
                pnotify(`Template error`, xhr.responseJSON.exception.message, 'error');
            }
        }
    );

});
