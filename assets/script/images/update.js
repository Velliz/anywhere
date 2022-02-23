$(document).ready(function () {

    var imageid = $('input[name=imageid]').val();

    var placeholderfile = $('input[name=placeholderfile]');
    var placeholder_holder = $('.placeholder_holder');

    var samplefile = $('input[name=samplefile]');
    var sample_holder = $('.sample_holder');

    placeholderfile.change(function (e) {
        e.preventDefault();

        waitingDialog.show('Processing Images');

        var filedata = $('input[name=placeholderfile]').prop("files")[0];
        var formdata = new FormData();

        formdata.append('placeholderfile', filedata);
        formdata.append('type', 'placeholder');
        formdata.append('id', imageid);

        $.ajax({
            url: 'api/placeholder',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            error: function (error) {
                location.reload();
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    samplefile.change(function (e) {
        e.preventDefault();

        waitingDialog.show('Processing Images');

        var filedata = $('input[name=samplefile]').prop("files")[0];
        var formdata = new FormData();

        formdata.append('samplefile', filedata);
        formdata.append('type', 'sample');
        formdata.append('id', imageid);

        $.ajax({
            url: 'api/placeholder',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            error: function (error) {
                location.reload();
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    var x = $('#crop_x').val();
    var y = $('#crop_y').val();
    var x2 = $('#crop_x2').val();
    var y2 = $('#crop_y2').val();
    var w = $('#crop_w').val();
    var h = $('#crop_h').val();

    $('#imagetarget').Jcrop({
        onSelect: showCoords,
        setSelect: [x, y, x2, y2],
        bgColor: 'black',
        bgOpacity: 0.3,
        boxWidth: 370
    });
});

function showCoords(c) {
    $('#crop_x').val(c.x);
    $('#crop_y').val(c.y);
    $('#crop_x2').val(c.x2);
    $('#crop_y2').val(c.y2);
    $('#crop_w').val(c.w);
    $('#crop_h').val(c.h);
}
