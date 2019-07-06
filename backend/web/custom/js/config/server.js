/**
 * Created by Chen on 2015/8/18.
 */
$(function () {



    $('.server-add').on('click', function () {
        $.ajax({
            url: '/config/server/add',
            type: 'get',
            success: function (html) {
                //ajaxCallback(html);
                modal = submitModal('增加服务器', '/config/server/add');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.server-batchupd').on('click', function () {
        var sid='';
        $('.server_id').each(function(){
            if($(this).is(':checked')){
                sid = sid+','+ $(this).data('sid');
            }
        });
        if(sid) {
            $.ajax({
                url: '/config/server/batchupd',
                type: 'get',
                data: 'sid=' + sid,
                success: function (html) {
                    //ajaxCallback(html);
                    modal = submitModal('批量修改渠道', '/config/server/batchupd');
                    modal.find('.modal-body').html(html);
                }
            });
        }else{
            bootbox.alert('请选择服务器！' || '系统错误');
        }
    });
    $('.server-upd').on('click', function () {
        var sid = $(this).data('id');
        $.ajax({
            url: '/config/server/upd',
            type: 'get',
            data: {'sid': sid},
            success: function (html) {
                modal = submitModal('编辑服务器', '/config/server/upd');
                modal.find('.modal-body').html(html);
            }
        });
    });
    $('.server-del').on('click', function () {
        var msg = "您真的确定要删除吗?\n删除完了也会清除对应的数据!\n请三思！";
        var sid = $(this).data('id');
        bootbox.confirm(msg,function(result){
            if(result===true){
                Confirm('确认删除吗？', '/config/server/del', {sid: sid});
            }
        });
    });
    $('.server-clear-file').on('click', function () {
        var msg = "您真的确定要清档吗?\n清档完了也会清除对应的数据!\n请三思！";
        var sid = $(this).data('id');
        var gameid = $(this).data('gameid');
        var openservertime = $(this).data('openservertime');
        bootbox.confirm(msg,function(result){
            if(result===true){
                Confirm('确认删除吗？', '/config/server/clearfile', {sid: sid,game_id:gameid,openservertime:openservertime});
            }
        });
    });

    $('#check').on('click',function(){
       if($(this).is(':checked')==true){
           $('.server_id').each(function(){
               $(this).prop('checked',true);
           });
       }else{
           $('.server_id').each(function(){
               $(this).prop('checked',false);
           });
       }
    });
});