<?php if(!empty($resultArr)):?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div id="echarts" class="center" style="height:300px"></div>
            </div>
        </div>
    </div>
<?php
$active_role = '玩家实时在线';
$time = [];
?>

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $active_role;?>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover ">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th><?php echo $active_role;?></th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($resultArr)) foreach (array_reverse($resultArr) as $key=>$value): ?>
                        <tr>
                            <td><?php echo date("Y-m-d H:i:s",$value['CP_sever_timestamp']); ?></td>
                            <td><?php echo $value['CP_online_count']; ?></td>
                        </tr>
                        <?php
                        $time[] = date("H:i:s",$value['CP_sever_timestamp']);
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $l_data = json_encode(array_reverse($time));
                $x_data = json_encode(array_values($resultArr));

                ?>
            </div>
        </div>
    </div>
</div>
<?php else:?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>暂无数据</div>
            </div>
        </div>
    </div>
<?php endif;?>

<script type="text/javascript">
<?php if(!empty($resultArr)):?>
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
                        name: '<?php echo $active_role;?>',
                        type: 'line',
                        data:
                        <?php
                        $tmp = array();
                        foreach($resultArr as $dts) {
                            $tmp[] = $dts['CP_online_count'];
                        }
                        echo json_encode($tmp);
                        ?>
                    }
                ]
            };
            chart_1.setOption(option);
        });

<?php endif;?>
</script>
