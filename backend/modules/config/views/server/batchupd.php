<form role="form" id="modalForm">
    <input type="hidden" name="server_ids" value="<?php echo $sid; ?>">
    <div class="form-group pull-left">
        <label for="channel_ids">渠道:</label>
        <div>
            <select class="form-control select1" multiple="multiple" id="channel_ids" name="channel_ids[]" style="height: 300px;">
                <?php foreach ($channel_list as $k => $v): ?>
                    <option value="<?php echo $k ?>" <?php if(isset($server_channel_list) && (in_array($k,$server_channel_list))) echo 'selected';?>><?php echo $v ?> | <?php echo $k;?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>

    <div class="form-group pull-left" style="padding: 20px 0 0 50px;">
        <label>渠道类型(根据左边结果生成)：</label><br>
        <?php
        foreach($server_type_list as $key=>$value){
            ?>
            <label class="control-label">
                <input type="radio" name="type"
                       value="<?php echo $key;?>" <?php echo (isset($item->server_type) && $item->server_type == $key) ? "checked='checked'" : ''; ?> disabled>
                <?php echo $value;?>
            </label>
            <br>
            <?php
        }
        ?>
        <br>
        <p id="channel_error" style="color: red;display: none;">渠道选择错误，请重新选择</p>
    </div>

    <div class="clearfix">

    </div>
</form>

<script charset="utf-8" type="text/javascript">
    $(function() {
        $('#game_id').on('')


        $("#channel_ids").on('click', function () {
            //alert($("#channel_ids").val());
            var channel_ids = $("#channel_ids").val();
            if(channel_ids == ''){
                return;
            }
            $.ajax({
                url: '/config/server/check-channel-type',
                type: 'get',
                data: {'channel_ids': channel_ids},
                dataType: 'json',
                success: function (json) {
                    if (json.ok != 1) {
                        //bootbox.alert(json.msg || '系统错误');
                        $(':radio').each(function () {
                            $(this).prop('checked', false);
                        });
                        $('#channel_error').css('display', 'block');
                    }
                    else {
                        $(':radio').each(function(){
                            $(this).prop('checked',false);
                            var value = $(this).val();
                            if(value == json.server_type){
                                $(this).prop('checked',true);
                            }
                        });
                        $('#channel_error').css('display', 'none');
                    }
                }
            });
        });
    });
</script>