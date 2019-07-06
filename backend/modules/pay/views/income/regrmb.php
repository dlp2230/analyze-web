<form action="" method="get" class="form-inline well" role="form" id="search_form">
    <div class="form-group">
        <lable>起始日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('start_time')?Yii::$app->request->get('start_time'):date('Y-m-d');?>" readonly class="form-control" id="start_time" name="start_time">
    </div>
    <div class="form-group">
        <lable>结束日期：</lable>
        <input type="text" value="<?php echo Yii::$app->request->get('end_time')?Yii::$app->request->get('end_time'):date('Y-m-d');?>" readonly class="form-control" id="end_time" name="end_time">
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button><span class="col-lg-pull-1 text-red">&nbsp;&nbsp;&nbsp;注:结束日期截止到当天23点59分59秒</span>
</form>
<div class="row">
    <?php
    use yii\widgets\LinkPager;
    if(!empty($resultArr)){
        $datamenu = '人民币充值';

        ?>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $datamenu;?>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead>
                            <tr>
                                <th>日期</th>
                                <th>角色UID</th>
                                <th>收入人民币(￥)</th>
                                <th>元宝</th>
                                <th>获得途径</th>

                                <th>流水订单号</th>
                            <tr>
                            </thead>
                            <tbody>
                            <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                                <tr>
                                    <td><?php echo date('Y-m-d H:i:s',$value['timestamp']); ?></td>
                                    <td><?php echo $value['role_id']; ?></td>
                                    <td><?php echo $value['CP_money']; ?></td>
                                    <td><?php echo $value['CP_game_money']; ?></td>
                                    <td><?php echo isset($payTypeConfig[$value['CP_type']][$value['CP_item_type']])?$payTypeConfig[$value['CP_type']][$value['CP_item_type']]:$value['CP_type'].'-'.$value['CP_item_type'];?></td>
                                    <td><?php echo isset($value['CP_order']) ? $value['CP_order'] : '无'; ?></td>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php echo $this->pager; ?>
            </div>
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