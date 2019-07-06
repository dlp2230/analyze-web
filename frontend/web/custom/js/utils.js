/**
 * Created by Chen on 2015/8/17.
 */
//表单提交modal自动处理
function submitModal(title, url) {
    return OpenModal({
        title: title,
        ok: function () {
            var data = modal.find('#modalForm').serialize();
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                success: function (json) {
                    //if (ajaxCallback(json)) {
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
                    //}
                }
            });
        }
    });
}

//快速确认操作
function Confirm(title, url, param) {
    return bootbox.confirm(title, function (result) {
        if (result === true) {
            $.get(url, param, function (json) {
                // if (ajaxCallback(json)) {
                if (json.ok == 1) {
                    if (json.receipt == 1) { //是否需要结果信息,弹出确认信息
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
                // }
            }, 'json');
        }
    });
}

function OpenModal(options) {
    $('body').find('#myModal').remove();
    var modal = $('<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        ' <div class="modal-header">' +
        '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' +
        '<h4 class="modal-title" id="myModalLabel">' + (options.title || '消息') + '</h4>' +
        '</div>' +
        '<div class="modal-body"><div class="loading"></div>' +
        '</div>' +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-default modal-cancel" data-dismiss="modal">取消</button>' +
        '<button type="button" class="btn btn-primary modal-save">确定</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>');

    $('body').append(modal);
    modal.find('.modal-cancel').on('click', options.cancel || function () {
        });
    modal.find('.modal-save').on('click', options.ok || function () {
        });

    $.fn.modal.Constructor.prototype.enforceFocus = function () { };
    $('#myModal').modal();
    return modal;
}

/**
 * 返回ajax进行校验 html或者object 权限提示
 * @param obj
 * @returns {boolean}
 * code : 1 回退1步
 */
//function ajaxCallback(obj) {
//    if (typeof obj != 'object') {
//        return true;
//    }
//    if (obj.ok == 0) {
//        if (obj.code == 1) {
//            bootbox.alert(obj.msg || '系统错误');
//            history.back();
//            return false;
//        }
//    }
//    return true;
//}