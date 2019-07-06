$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('input').on('keyup', function () {
        $('.form-group').removeClass('has-error');
    });
});