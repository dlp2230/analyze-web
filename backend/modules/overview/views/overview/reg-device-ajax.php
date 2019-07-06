<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="reg_device" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
  $reg_device = '新增设备';

?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $reg_device;?>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th><?php echo $reg_device;?></th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php if(isset($regDeviceArr)) foreach ($regDeviceArr as $key=>$value): ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $value; ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
                 <?php
                   $l_data = json_encode(array_keys($regDeviceArr));
                   $x_data = json_encode(array_values($regDeviceArr));

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

            var chart_1 = ec.init(document.getElementById('reg_device'));
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:['<?php echo $reg_device;?>']
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
                            title: '<?php echo $reg_device;?>',
                            type: 'png'
                        }
                    }

                },
                calculable: true,
                xAxis: [
                    {
                        name: '时间',
                        type: 'category',
                       // boundaryGap: false,
                        data:<?php echo $l_data;?>
                    }
                ],

                yAxis: [
                    {
                        name: '设备数(台)',
                        type: 'value'
                    }
                ],
                series: [

                    {
                        name: '<?php echo $reg_device;?>',
                        type: 'bar',
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
                        },
                        data:
                        <?php
                        $tmp = array();
                        foreach($regDeviceArr as $dts) {
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
