/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.channel-add').on('click', function () {
        $.ajax({
            url: '/config/channel/add',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加渠道', '/config/channel/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.channel-upd').on('click', function () {
        var channel_id = $(this).data('id');
        $.ajax({
            url: '/config/channel/upd',
            type: 'get',
            data: {'channel_id': channel_id},
            success: function (html) {
                modal = submitModal('编辑渠道', '/config/channel/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.channel-del').on('click', function () {
        var channel_id = $(this).data('id');
        Confirm('确认删除吗？', '/config/channel/del', {channel_id: channel_id});
    });

    $('.cps-add').on('click', function () {
        $.ajax({
            url: '/config/cps/add',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加分包', '/config/cps/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.cps-upd').on('click', function () {
        var cps_id = $(this).data('id');
        $.ajax({
            url: '/config/cps/upd',
            type: 'get',
            data: {'cps_id': cps_id},
            success: function (html) {
                modal = submitModal('编辑分包', '/config/cps/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.cps-del').on('click', function () {
        var cps_id = $(this).data('id');
        Confirm('确认删除吗？', '/config/cps/del', {cps_id: cps_id});
    });
});