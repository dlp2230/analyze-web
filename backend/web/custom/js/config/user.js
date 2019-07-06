/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.userGroup-add').on('click', function () {
        $.ajax({
            url: '/config/admin-group/add',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加用户组', '/config/admin-group/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.userGroup-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/config/admin-group/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('编辑用户组', '/config/admin-group/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.userGroup-setting').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/config/admin-group/setting',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                //ajaxCallback(html);
                //submitModal('编辑权限', '/config/admin-group/setting');
                modal = OpenModal({
                    title: '编辑权限',
                    ok: function () {
                        //1.抓取模态框里面所有选中的子节点
                        var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
                        var nodes = treeObj.getCheckedNodes(true);
                        var data = new Array();
                        $(nodes).each(function () {
                            if (this.value != null) {
                                data.push(this.value);
                            }
                        });
                        $.ajax({
                            url: '/config/admin-group/setting',
                            data: {
                                ag_id: $('#ag_id').val(),
                                perm: JSON.stringify(data)
                            },
                            type: 'post',
                            dataType: 'json',
                            success: function (json) {
                                //ajaxCallback(json);
                                if (json.ok == 1) {
                                    if (json.code == 1) { //状态为1,弹出确认信息
                                        modal = OpenModal({
                                            title: '信息',
                                            ok: function () {
                                                window.location.reload();
                                            }
                                        });
                                        modal.find('.modal-body').html(json.msg);
                                    } else {
                                        window.location.reload();
                                    }
                                } else {
                                    bootbox.alert(json.msg || '系统错误');
                                }
                            }
                        });
                    }
                });
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.userGroup-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/admin-group/del', {id: id});
    });
    $('.user-add').on('click', function () {
        $.ajax({
            url: '/config/admin/add',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加用户', '/config/admin/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.user-batchupd').on('click', function () {
        $.ajax({
            url: '/config/admin/batchupd',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('批量修改游戏', '/config/admin/batchupd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.user-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/config/admin/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('编辑用户', '/config/admin/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.user-reset').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认重置密码吗？', '/config/admin/reset', {id: id});
    });

    $('.user-del').on('click', function () {
        var id = $(this).data('id');
        Confirm('确认删除吗？', '/config/admin/del', {id: id});
    });
});