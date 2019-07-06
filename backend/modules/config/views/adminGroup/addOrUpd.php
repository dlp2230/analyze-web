<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit'): ?>
        <input type="hidden" id="oid" name="oid" value="<?php echo $item->ag_id; ?>"/>
    <?php endif; ?>

    <div class="form-group">
        <label for="title">用户组:</label>
        <input type="text" class="form-control" name="name" id="name"
               placeholder="" value="<?php echo isset($item->name) ? $item->name : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="link">描述:</label>
        <input type="text" class="form-control" name="description" id="description"
               placeholder="" value="<?php echo isset($item->description) ? $item->description : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="title">类别:</label><br>
        <label class="radio-inline">
            <input type="radio" name="type" id="type"
                   value="1" <?php echo (isset($item->type) && $item->type == 1) ? 'checked' : '' ?>/>
            超级
        </label>
        <label class="radio-inline">
            <input type="radio" name="type" id="type"
                   value="2" <?php echo (!isset($item->type) || (isset($item->type) && $item->type == 2)) ? 'checked' : '' ?>/>
            普通
        </label>
    </div>
</form>