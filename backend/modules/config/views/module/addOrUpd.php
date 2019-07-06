<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit'): ?>
        <input type="hidden" id="oid" name="oid" value="<?php echo $item->id; ?>"/>
    <?php endif; ?>

    <div class="form-group">
        <label for="title">模块:</label>
        <input type="text" class="form-control" name="id" id="id"
               placeholder="module" value="<?php echo isset($item->id) ? $item->id : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="day">权限标识:</label>
        <input type="text" class="form-control" name="perm_id" id="perm_id"
               placeholder="MODULE"
               value="<?php echo isset($item->perm_id) ? $item->perm_id : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="link">权限定义:</label>
        <input type="text" class="form-control" name="name" id="name"
               placeholder="新增xx" value="<?php echo isset($item->name) ? $item->name : '' ?>"/>
    </div>
</form>
<script charset="utf-8" type="text/javascript">
    $(function() {
        $("#id").on('keyup focusout',function(){
            var value = $("#id").val().toUpperCase();
            $('#perm_id').val(value);
        });
    });
</script>