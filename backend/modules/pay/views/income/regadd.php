<form action="" method="get" class="form-inline well" role="form" >
    <div class="form-group">
        <lable>起始日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('start_time')?Yii::$app->request->get('start_time'):date('Y-m-d');?>" readonly class="form-control" id="start_time" name="start_time">
    </div>
    <div class="form-group">
        <lable>结束日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('end_time')?Yii::$app->request->get('end_time'):date('Y-m-d');?>" readonly class="form-control" id="end_time" name="end_time">
    </div>
    <div class="form-group">
        <lable>角色ID：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('role_id')?Yii::$app->request->get('role_id'):'';?>"  placeholder="请输入角色ID" class="form-control" id="role_id" name="role_id">
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button><span class="col-lg-pull-1 text-red">&nbsp;&nbsp;&nbsp;注:结束日期截止到当天23点59分59秒</span>
</form>
<div class="row">
    <?php
        if(!empty($resultArr)){
            $game_id = Yii::$app->session->get('game_id');
            $typesArr = isset(Yii::$app->params['consumptionType_'.$game_id])?Yii::$app->params['consumptionType_'.$game_id]:[];
       ?>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    GM赠送币
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead>
                            <tr>
                                <th>日期</th>
                                <th>角色UID</th>
                                <th>货币量</th>
                                <th>获得途径</th>
                            <tr>
                            </thead>
                            <tbody>
                            <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                                <tr>
                                    <td><?php echo date('Y-m-d H:i:s',$value['timestamp']); ?></td>
                                    <td><?php echo $value['role_id']; ?></td>
                                    <td><?php echo $value['CP_true_num']+$value['CP_false_num']; ?></td>
                                    <td><?php echo isset($typesArr[$value['CP_type']]) ? $typesArr[$value['CP_type']]:$value['CP_type']; ?></td>


                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo $this->pager; ?>
        </div>
    <?php }else {
        ?>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    暂无数据
                </div>
            </div>
        </div>
        <?php
    }
    ?>

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