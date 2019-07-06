/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.perm-add').on('click', function () {
        $.ajax({
            url: '/config/perm/add',
            type: 'get',
            success: function (html) {
                modal = submitModal('新录入权限', '/config/perm/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.perm-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/config/perm/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                modal = submitModal('更新权限', '/config/perm/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.perm-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/perm/del', {id: id});
    });
    $('.permGroup-add').on('click', function () {
        $.ajax({
            url: '/config/perm-group/add',
            type: 'get',
            success: function (html) {
                modal = submitModal('新录入权限组', '/config/perm-group/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.permGroup-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/config/perm-group/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                modal = submitModal('更新权限组', '/config/perm-group/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.permGroup-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/perm-group/del', {id: id});
    });
    $('.module-add').on('click', function () {
        $.ajax({
            url: '/config/module/add',
            type: 'get',
            success: function (html) {
                modal = submitModal('新录入模块', '/config/module/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.module-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/config/module/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {

                modal = submitModal('更新模块', '/config/module/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.module-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/module/del', {id: id});
    });
});