<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit'): ?>
        <input type="hidden" id="oid" name="oid" value="<?php echo $item->channel_id; ?>"/>
    <?php endif; ?>

    <div class="form-group">
        <label for="channel_id">渠道id:</label>
        <input type="text" class="form-control" name="channel_id" id="channel_id"
                value="<?php echo isset($item->channel_id) ? $item->channel_id : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="name">渠道名称:</label>
        <input type="text" class="form-control" name="name" id="name"
               value="<?php echo isset($item->name) ? $item->name : '' ?>"/>
    </div>
    <div class="form-group">
        <label>类型：</label>
        <?php
        foreach($device_type as $key=>$value){
            ?>
            <label class="control-label">
                <input type="radio" name="type"
                       value="<?php echo $key;?>" <?php echo (isset($item['type']) && $item['type'] == $key) ? "checked='checked'" : ''; ?>>
                <?php echo $value;?>
            </label>
            <?php
        }
        ?>
    </div>

</form>