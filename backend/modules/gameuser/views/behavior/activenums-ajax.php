<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="role" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
$active_role = '人均游戏次数';

?>

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            活跃玩家游戏次数
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover ">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>活跃角色数(人)</th>
                        <th>游戏总次数(次)</th>
                        <th>人均游戏次数(次)</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($ProportionArr)) foreach (array_reverse($ProportionArr) as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value['active']; ?></td>
                            <td><?php echo $value['active_nums']; ?></td>
                            <td><?php echo $value['svg']; ?></td>
                        </tr>
                        <?php
                           $y_data[] = $value['svg'];
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $l_data = json_encode(array_keys($ProportionArr));
                $x_data = json_encode(array_reverse($y_data));

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
                    data:['<?php echo $active_role;?>']
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
                            title: '<?php echo $active_role;?>',
                            type: 'png'
                        }
                    }

                },
                calculable: true,
                xAxis: [
                    {
                        name: '时间',
                        type: 'category',
                        boundaryGap: true,
                        data:<?php echo $l_data;?>
                    }
                ],

                yAxis: [
                    {
                        name: '人次(次)',
                        type: 'value'
                    }
                ],
                series: [

                    {
                        name: '<?php echo $active_role;?>',
                        type: 'bar',
                        data:
                        <?php
                        $tmp = array();
                        foreach($ProportionArr as $dts) {
                            $tmp[] = $dts['svg'];
                        }
                        echo json_encode($tmp);
                        ?>
                        ,
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                                {type: 'min', name: '最小值'}
                            ]
                        },
                        markLine: {
                            data: [
                                {type: 'average', name: '平均值'}
                            ]
                        }
                    }
                ]
            };
            chart_1.setOption(option);
        });


</script>
