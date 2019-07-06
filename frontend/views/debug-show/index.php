<?php
  $type = !empty(Yii::$app->request->get('type')) ? Yii::$app->request->get('type') : 1;
?>
<form action="" method="get" class="form-inline well" role="form" id="search_form_ajax">
    <div class="form-group">
        <lable>游戏ID：</lable>
        <input type="number" value="<?php echo !empty(Yii::$app->request->get('game_id')) ? Yii::$app->request->get('game_id') : '';?>"  class="form-control" id="game_id" name="game_id" placeholder="请输入游戏ID" required/>
    </div>
    <div class="form-group">
        <lable>区服ID：</lable>
        <input type="number" value="<?php echo !empty(Yii::$app->request->get('server_id')) ? Yii::$app->request->get('server_id') : '';?>"  class="form-control" id="server_id" name="server_id" placeholder="请输入区服ID" required/>
    </div>
    <div class="form-group">
        <lable>角色ID：</lable>
        <input type="text" value="<?php echo !empty(Yii::$app->request->get('role_id')) ? Yii::$app->request->get('role_id') : '';?>"  class="form-control" id="role_id" name="role_id" placeholder="请输入角色ID" required/>
    </div>
    <div class="form-group">
        <label for="game_id">接口类型：</label>
        <div class="form-group">
            <select class="form-control select1" id="type" name="type">
                <?php foreach ($behavior_type as $k => $v): ?>
                    <option value="<?php echo $k ?>" <?php echo $k==$type ?'selected':'';?>><?php echo $v ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button>
</form>
<div class="row" id="ajax-content">

</div>
