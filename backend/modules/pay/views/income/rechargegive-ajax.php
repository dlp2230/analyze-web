<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="echarts" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
  $datamenu = '充值+赠送';

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
                        <th>充值(￥)</th>
                        <th>充值充值币</th>
                        <th>充值赠送币</th>

                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($LossArr)) foreach ($LossArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value['CP_money']; ?></td>
                            <td><?php echo $value['CP_true_num']; ?></td>
                            <td><?php echo $value['CP_false_num']; ?></td>

                        </tr>
                        <?php
                        $dtss[] = $key;

                        ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
              <?php
                $x_data = json_encode($dtss);
                $retentionDay = ['CP_true_num'=>'充值充值币','CP_false_num'=>'充值赠送币'];
                $l_data = json_encode(array_values($retentionDay));
                $key_data = array_keys($retentionDay);
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

            var chart_1 = ec.init(document.getElementById('echarts'));
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:<?php echo $l_data; ?>
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
                            title: '充值分析',
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
                        data:<?php echo $x_data;?>
                    }
                ],
                calculable: true,
                yAxis: [
                    {
                        name: '充值币',
                        type: 'value'
                    }
                ],
                series: [
                    <?php
                    for($i = 0; $i < count($key_data); $i ++) {
                    $act = $key_data[$i];
                    ?>
                    {
                        name: '<?php echo $retentionDay[$act];?>',
                        type: 'line',
                        data:
                        <?php
                        $tmp = array();
                        foreach($dtss as $dts) {
                            if(isset($LossArr[$dts])) {
                                $tmp[] = $LossArr[$dts][$act];
                            } else {
                                $tmp[] = 0;
                            }
                        }
                        echo json_encode($tmp);
                        ?>
                    }
                    <?php
                    if($i != count($key_data) - 1) {
                        echo ',';
                    }
                    }
                    ?>


                ]
            };
            chart_1.setOption(option);
        });


</script>
