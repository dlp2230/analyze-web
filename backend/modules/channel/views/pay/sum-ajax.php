<?php $role_add = '付费金额'; if($list){ ?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="role" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $role_add;?>
        </div>

        <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                        <tr>
                            <th>区服</th>
                            <th><?php echo $role_add;?></th>
                        <tr>
                        </thead>
                        <tbody>
                        <?php  foreach ($list as $value): ?>
                            <tr>
                                <td><?php echo $value['server_name']; ?></td>
                                <td><?php echo $value['CP_money']; ?></td>
                            </tr>
                            <?php
                            $all[]=$value['server_name'];
                            $tmp[] = intval($value['CP_money']);
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    require.config({
        paths: {
            echarts: '<?php echo Yii::$app->params['returnEcharts'];?>'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/line',
            'echarts/chart/bar'
        ],
        function (ec) {

            var chart_1 = ec.init(document.getElementById('role'));
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:['<?php echo $role_add;?>']
                },
                toolbox: {
                    show: true,

                    feature: {
                        mark: {
                            show: true
                        },
                        dataView: {
                            show: false
                        },
                        magicType: {
                            show: true,
                            type: ['line', 'bar', 'stack', 'tiled']
                        },
                        restore: {
                            show: true
                        },
                        saveAsImage: {
                            show: true,
                            title: '<?php echo $role_add;?>',
                            type: 'png'
                        }
                    }

                },
                calculable: true,
                xAxis: [
                    {
                        name: '区服',
                        data:<?php echo json_encode($all);?>
                    }
                ],

                yAxis: [
                    {
                        name: '人数(个)',
                        type: 'value'
                    }
                ],
                series: [

                    {
                        name: '<?php echo $role_add;?>',
                        type: 'bar',
                        data:<?php echo json_encode($tmp); ?>
                    }
                ]
            };
            chart_1.setOption(option);
        });


</script>
<?php }else{?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $role_add;?>
        </div>

        <div class="panel-body">
            <?php if(!$list){echo '暂无数据';}}?>

        </div>
    </div>
</div>