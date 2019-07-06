/**
 * Created by Chen on 2015/8/18.
 */
$(function () {
    $('.slb-upd').on('click', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/ops/slb/upd',
            type: 'get',
            data: {'id': id},
            success: function (html) {
                ajaxCallback(html);
                modal = submitModal('更新信息', '/ops/slb/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.slb-sync').on('click', function () {
        bootbox.confirm('确认开始同步么?需要一段时间.', function (result) {
            if (result === true) {
                $('#sync-finish').hide();
                $('#sync-loading').show();
                $.get('/ops/slb/sync', function (json) {
                    if (ajaxCallback(json)) {
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
                }, 'json');
            }
        });
    });
});