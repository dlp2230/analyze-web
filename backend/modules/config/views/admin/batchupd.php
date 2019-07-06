<form role="form" id="modalForm">
    <div class="form-group">
        <label>用户名:</label>
        <select class="form-control" name="id[]" multiple>
            <?php foreach ($item as $key => $name): ?>
                <option
                    value="<?php echo $key; ?>"><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>授权产品:</label>
        <select class="form-control" name="game_ids[]" multiple>
            <?php foreach ($games as $key => $name): ?>
                <option
                    value="<?php echo $key; ?>" ><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

