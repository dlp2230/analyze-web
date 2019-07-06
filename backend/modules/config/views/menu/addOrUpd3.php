<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit') { ?>
        <input type="hidden" id="oid" name="oid" value="<?php echo $item->id; ?>"/>
    <?php } else { ?>
        <input type="hidden" id="pid" name="pid" value="<?php echo $pid; ?>"/>
    <?php } ?>
    <div class="form-group">
        <label for="title">菜单名称:</label>
        <input type="text" class="form-control" name="menu_name" id="menu_name"
               placeholder="后台配置" value="<?php echo isset($item->menu_name) ? $item->menu_name : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="title">路由地址:</label>
        <input type="text" class="form-control" name="route" id="route"
               placeholder="/config/sss/sss" value="<?php echo isset($item->route) ? $item->route : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="day">权限标识:</label>
        <input type="text" class="form-control" name="menu_perm_id" id="menu_perm_id"
               placeholder="CONFIG_XX_XX"
               value="<?php echo isset($item->menu_perm_id) ? $item->menu_perm_id : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="link">排序:</label>
        <input type="text" class="form-control" name="sort" id="sort"
               placeholder="" value="<?php echo isset($item->sort) ? $item->sort : '' ?>"/>
    </div>
</form>

<script charset="utf-8" type="text/javascript">
    $(function() {
        $("#route").on('keyup focusout',function(){
            var value = $("#route").val();
            if(value.indexOf('/') !==0){
                $("#route").val('/'+value);
            }
            $('#menu_perm_id').val(value.substr(1).replace(/-/g, '').replace(/\//g, '_').toUpperCase());
        });
    });
</script>