<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="playerloss" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
  $datamenu = '首付分析';

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
                        <th>新增付费用户(人)</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value['pay_nums']; ?></td>
                        </tr>
                        <?php
                           $y_data[] = $value['pay_nums'];
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $l_data = json_encode(array_keys($resultArr));
                $x_data = json_encode($y_data);

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

            var chart_1 = ec.init(document.getElementById('playerloss'));
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:['<?php echo $datamenu;?>']
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
                            title: '<?php echo $datamenu;?>',
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
                        name: '新增付费人数(人)',
                        type: 'value'
                    }
                ],
                series: [

                    {
                        name: '<?php echo $datamenu;?>',
                        type: 'bar',
                        data:
                        <?php
                        $tmp = array();
                        foreach($resultArr as $dts) {
                            $tmp[] = $dts['pay_nums'];
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
