/**
 * Created by Chen on 2015/11/6.
 */
$(function () {
    $('#select_menu_channel').select2();

    $('.need-check').each(function () {
        if (perm.indexOf($(this).data('permid').toString()) > -1) {
            $(this).show();
        }
    });


    //自动填写查询表单
    $search_form = $("#search_form");
    if ($search_form.length > 0) {
        for (var tag in search_data) {
            $item = $search_form.find('#' + tag);
            if ($item.length > 0) {
                //该元素是存在的
                var tagName = $item[0].tagName;
                if (tagName == 'SELECT') {
                    $item.find("option[value='" + search_data[tag] + "']").prop("selected", true);
                }
                if (tagName == 'INPUT') {
                    $item.val(search_data[tag]);
                }
            }
        }
    }
    $('#select_menu_game_id').on('change', function () {
        var game_id = $('#select_menu_game_id').val();
        $.get('/system/system/select-game-id',
            {'game_id': game_id},
            function (callback) {
                if (callback.ok == 1) {
                    if ($('#menuType').val() == 'gsc') {
                        //清空其他状态
                        $("#select_menu_server_type option[value='']").prop("selected", "selected");
                        $("#select_menu_server option[value!='']").remove();
                        $("#select_menu_channel option[value!='']").remove();
                    } else if ($('#menuType').val() == 'gc') {
                        //$("#select_menu_channel option:first").prop("selected", 'selected');

                        $("#select_menu_channel").val($("#select_menu_channel option:first").val()).change();
                    }
                }
            }, 'json'
        );
    });

    $('#select_menu_server_type').on('change', function () {
        var server_type = $('#select_menu_server_type').val();
        $.get('/system/system/select-server-type',
            {'server_type': server_type},
            function (callback) {
                if (callback.ok == 1) {
                    //清空其他状态
                    $("#select_menu_server option[value!='']").remove();
                    $("#select_menu_channel option[value!='']").remove();
                    //构建区服列表
                    $.each(callback.data, function (k, v) {
                        $("#select_menu_server").append("<option value='" + k + "'>" + v + "</option>");
                    });
                }
            }, 'json'
        );
    });

    $('#select_menu_server').on('change', function () {
        var server = $('#select_menu_server').val();
        $.get('/system/system/select-server',
            {'server': server},
            function (callback) {
                if (callback.ok == 1) {
                    //清空其他状态
                    $("#select_menu_channel option[value!='']").remove();
                    //构建平台列表
                    $.each(callback.data, function (k, v) {
                        $("#select_menu_channel").append("<option value='" + k + "'>" + v + "</option>");
                    });
                }
            }, 'json'
        );
    });

    $('#select_menu_channel').on('change', function () {
        var channel = $('#select_menu_channel').val();
        $.get('/system/system/select-channel',
            {'channel': channel},
            function (callback) {
                if (callback.ok == 1) {
                }
            }, 'json'
        );
    });

    $('#search_form_ajax').on('submit', function () {
        $submit = $(this).find(':submit');
        $submit.prop('disabled', true);
        $submit.html('检索中');
        $search_form_ajax = $('#search_form_ajax');
        if ($('#menuType').length > 0) {
            if ($('#menuType').val() == 'gsc') {
                //存在左侧4个选择框
                var game_id = $('#select_menu_game_id').val();
                var server_type = $('#select_menu_server_type').val();
                var server = $('#select_menu_server').val();
                var channel = $('#select_menu_channel').val();
                if (game_id == '' || server == '') {
                    bootbox.alert('请选择左侧查询条件！' || '系统错误');
                    $submit.prop('disabled', false);
                    $submit.html('检索');
                    return false;
                }
                $.ajax({
                    url: '/system/system/gsc-set-left-select',
                    data: {'game_id': game_id, 'server_type': server_type, 'server': server, 'channel': channel},
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    success: function (msg) {
                        if (msg.ok != 1) {
                            bootbox.alert(json.msg | '系统错误');
                        }
                    }
                });
            } else if ($('#menuType').val() == 'gc') {
                //存在左侧4个选择框
                var game_id = $('#select_menu_game_id').val();
                var channel = $('#select_menu_channel').val();
                if (game_id == '' || server == '') {
                    bootbox.alert('请选择左侧查询条件！' || '系统错误');
                    $submit.prop('disabled', false);
                    $submit.html('检索');
                    return false;
                }
                $.ajax({
                    url: '/system/system/gc-set-left-select',
                    data: {'game_id': game_id, 'channel': channel},
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    success: function (msg) {
                        if (msg.ok != 1) {
                            bootbox.alert(json.msg | '系统错误');
                        }
                    }
                });
            }
        }
        $.ajax({
            url: $search_form_ajax.prop('action'),
            data: $search_form_ajax.serialize(),
            type: $search_form_ajax.prop('method'),
            success: function (msg) {
                if (typeof(msg) == "object" && msg.ok != 1) {
                    bootbox.alert(msg.msg);
                }
                else {
                    $submit.prop('disabled', false);
                    $submit.html('检索');
                    $('#ajax-content').html(msg);
                }
            }
        });
        return false;
    });


})
;

