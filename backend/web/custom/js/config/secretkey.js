$(function () {
    $('.secretkey-add').on('click', function () {
        $.ajax({
            url: '/config/secretkey/add',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加游戏', '/config/secretkey/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.phatform-upd').on('click', function () {
        var game_id = $(this).data('id');

        $.ajax({
            url: '/config/secretkey/upd',
            type: 'get',
            data: {'game_id': game_id},
            success: function (html) {
                modal = submitModal('编辑游戏', '/config/secretkey/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });

    $('.phatform-status').on('click', function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        if(status==1){
            var start='禁用';
        }else{
            var start='启用';
        }
        Confirm('确认'+start+'吗？', '/config/secretkey/status', {game_id: id});
    });
});