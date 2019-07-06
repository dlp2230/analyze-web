<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit'): ?>
        <input type="hidden" id="oid" name="oid" value="<?php echo $item->cps_id; ?>"/>
    <?php endif; ?>

    <div class="form-group">
        <label for="cps_id">分包id:</label>
        <input type="text" class="form-control" name="cps_id" id="cps_id"
                value="<?php echo isset($item->cps_id) ? $item->cps_id : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="channel_id">渠道id:</label>
        <div>
            <select class="form-control select1" id="channel_id" name="channel_id" style="width: 300px;">
                <?php foreach ($channel_list as $k => $v): ?>
                    <option value="<?php echo $k ?>" <?php if(isset($item->channel_id) && ($item->channel_id ==$k)) echo 'selected';?>><?php echo $v ?> | <?php echo $k;?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>
    <div class="form-group">
        <label for="name">分包名称:</label>
        <input type="text" class="form-control" name="name" id="name"
               value="<?php echo isset($item->name) ? $item->name : '' ?>"/>
    </div>
</form>
<script charset="utf-8" type="text/javascript">
    $(function() {
        $('.select1').select2();
    });
</script>