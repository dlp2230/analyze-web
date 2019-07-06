<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="playerloss" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
  $loseday = Yii::$app->request->get('loseday');
  $loseday = isset($loseday) ? $loseday : 7;
  $datamenu = $loseday.'日平均贡献';

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
                        <th>新增角色(人)</th>

                        <th><?php echo $datamenu;?></th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($LossArr)) foreach (array_reverse($LossArr) as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value['reg_role']; ?></td>

                            <td><?php echo $value['svg']; ?></td>
                        </tr>
                        <?php
                           $y_data[] = $value['svg'];
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $l_data = json_encode(array_keys($LossArr));
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
                        boundaryGap: false,
                        data:<?php echo $l_data;?>
                    }
                ],

                yAxis: [
                    {
                        name: '流失用户数(人)',
                        type: 'value'
                    }
                ],
                series: [

                    {
                        name: '<?php echo $datamenu;?>',
                        type: 'line',
                        data:
                        <?php
                        $tmp = array();
                        foreach($LossArr as $dts) {
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
