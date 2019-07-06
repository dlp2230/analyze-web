<form action="" method="get" class="form-inline well" role="form" id="search_form_ajax">
    <div class="form-group">
        <lable>选择日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('start_time')?Yii::$app->request->get('start_time'):date('Y-m-d');?>" readonly class="form-control" id="start_time" name="start_time">
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button>
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
</script>