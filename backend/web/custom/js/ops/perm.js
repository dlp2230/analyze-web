/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.perm-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/ops/perm/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                ajaxCallback(html);
                modal = submitModal('更新职责', '/ops/perm/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });

    $('.permGroup-add').on('click', function () {
        $.ajax({
            url: '/ops/permGroup/add',
            type: 'get',
            success: function (html) {
                ajaxCallback(html);
                modal = submitModal('新录入职责组', '/ops/permGroup/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.permGroup-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/ops/permGroup/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                ajaxCallback(html);
                modal = submitModal('更新职责组', '/ops/permGroup/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.permGroup-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/ops/permGroup/del', {id: id});
    });
});