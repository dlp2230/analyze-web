<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="role" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
$role_add = '新增角色';

?>
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
                            <th>日期</th>
                            <th><?php echo $role_add;?></th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php if(isset($regRoleArr)) foreach ($regRoleArr as $key=>$value): ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $l_data = json_encode(array_keys($regRoleArr));
                $x_data = json_encode(array_values($regRoleArr));
                ?>
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
                        name: '时间',
                        type: 'category',
                        boundaryGap: false,
                        data:<?php echo $l_data;?>
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
                        type: 'line',
                        data:
                        <?php
                        $tmp = array();
                        foreach($regRoleArr as $dts) {
                            $tmp[] = intval($dts);
                        }
                        echo json_encode($tmp);
                        ?>
                    }
                ]
            };
            chart_1.setOption(option);
        });


</script>