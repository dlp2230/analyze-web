<form action="" method="get" class="form-inline well" role="form" id="search_form_ajax">
    <div class="form-group">
        <lable>起始日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('start_time')?Yii::$app->request->get('start_time'):date('Y-m-d');?>" readonly class="form-control" id="start_time" name="start_time">
    </div>
    <div class="form-group">
        <lable>结束日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('end_time')?Yii::$app->request->get('end_time'):date('Y-m-d');?>" readonly class="form-control" id="end_time" name="end_time">
    </div>
    <div class="form-group">
        <lable>流失天数：</lable>
        <select name="loseday" class="form-control" id="loseday">
           <?php
              foreach ($loseDays as $item){
                  echo '<option value="'.$item.'">'.$item.'日未登录</option>';
              }
           ?>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button><span class="col-lg-pull-1 text-red">&nbsp;&nbsp;&nbsp;注:结束日期截止到当天23点59分59秒</span>
</form>
<div class="row" id="ajax-content">

</div>
<script type="text/javascript">
    $("#start_time").datetimepicker({
        //format: 'yyyy-mm-dd hh:ii',
        format: 'yyyy-mm-dd',
        language:'zh-CN',
        minView:'2',
    });
    $("#end_time").datetimepicker({
        format: 'yyyy-mm-dd',
        language:'zh-CN',
        minView:'2',
    });

</script>