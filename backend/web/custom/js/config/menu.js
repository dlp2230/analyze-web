/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.menu-add').on('click', function () {
        var level = $(this).data('level');
        var pid = $(this).data('pid');
        $.ajax({
            url: '/config/menu/add',
            type: 'get',
            data: {'pid': pid, 'level': level},
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加菜单', '/config/menu/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.menu-upd').on('click', function () {
        var level = $(this).data('level');
        var id = $(this).data('id');
        $.ajax({
            url: '/config/menu/upd',
            type: 'get',
            data: {'id': id, 'level': level},
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('编辑菜单', '/config/menu/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.menu-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/menu/del', {id: id});
    });
});