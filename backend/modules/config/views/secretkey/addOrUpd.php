<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit'): ?>
        <input type="hidden" id="oid" name="oid" value="<?php echo $item->game_id; ?>"/>
        <input type="hidden" id="private_key" name="private_key" value="<?php echo $item->private_key; ?>"/>
    <?php endif; ?>
    <input type="hidden" id="status" name="status" value="<?php echo isset($item->status) ? $item->status : '1'; ?>"/>
    <div class="form-group">
        <label for="title">游戏id:</label>
        <input type="text" class="form-control" name="game_id" id="game_id"
                value="<?php echo isset($item->game_id) ? $item->game_id : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="title">游戏秘钥:</label>
        <input type="text" class="form-control" name="private_key" id="private_key" <?php echo isset($item->private_key) ? 'disabled="true"' : ''; ?>
               value="<?php echo isset($item->private_key) ? $item->private_key : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="day">游戏名称:</label>
        <input type="text" class="form-control" name="name" id="name"
               value="<?php echo isset($item->name) ? $item->name : '' ?>"/>
    </div>
</form>