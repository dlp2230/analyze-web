<form role="form" id="modalForm">
    <?php if (isset($type) && $type == 'edit'): ?>
        <input type="hidden" name="oid" value="<?php echo $item->id; ?>"/>
    <?php endif; ?>

    <div class="form-group">
        <label for="title">登录邮箱:</label>
        <input type="text" class="form-control" name="email"
               placeholder="xxx@founq.com" value="<?php echo isset($item->email) ? $item->email : '' ?>"/>
    </div>
    <div class="form-group">
        <label for="title">昵称:</label>
        <input type="text" class="form-control" name="name"
               placeholder="XXX" value="<?php echo isset($item->name) ? $item->name : '' ?>"/>
    </div>
    <div class="form-group">
        <label>所属用户组:</label>
        <select class="form-control" name="ag_id">
            <?php foreach ($userGroup as $key => $name): ?>
                <option
                    value="<?php echo $key; ?>" <?php if (isset($item->ag_id) && $item->ag_id == $key) echo "selected"; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>授权产品:</label>
        <select class="form-control" name="game_ids[]" multiple>
            <?php foreach ($games as $key => $name): ?>
                <option
                    value="<?php echo $key; ?>" <?php if (isset($game_ids) && in_array($key, $game_ids)) echo "selected"; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>移动电话:</label>
        <input type="text" name="mobile" class="form-control"
               value="<?php echo isset($item['mobile']) ? $item['mobile'] : '' ?>">
    </div>
    <div class="form-group">
        <label>状态</label>
        <label class="control-label">
            <input type="radio" name="status"
                   value="1" <?php echo (isset($item['status']) && $item['status'] == '1') ? "checked='checked'" : ''; ?>>
            启用
        </label>
        <label class="">
            <input type="radio" name="status"
                   value="0" <?php echo (isset($item['status']) && $item['status'] == '0') ? "checked='checked'" : ''; ?>>
            禁用
        </label>
    </div>
</form>

