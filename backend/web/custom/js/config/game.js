/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.game-add').on('click', function () {
        //var game_id = $(this).data('game_id');
        //var name = $(this).data('name');
        $.ajax({
            url: '/config/game/add',
            type: 'get',
            //data: {'game_id': game_id, 'name': name},
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加游戏', '/config/game/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.game-upd').on('click', function () {
        var game_id = $(this).data('id');

        $.ajax({
            url: '/config/game/upd',
            type: 'get',
            data: {'game_id': game_id},
            success: function (html) {
                modal = submitModal('编辑游戏', '/config/game/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.game-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/game/del', {game_id: id});
    });
});