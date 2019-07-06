<?php if(!empty($resultArr)):?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="playerloss" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<?php
  $datamenu = '消费排行榜';

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
                        <th>排名</th>
                        <th>渠道名称</th>
                        <th>区服ID</th>
                        <th>角色ID</th>
                        <th>累积付费(￥)</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key+1;?></td>
                            <?php
                            $channelName = isset($channelArr[$value['channel_id']]) ? $channelArr[$value['channel_id']] : $value['channel_id'];
                            echo '<td>'.$channelName.'</td>';
                            ?>
                            <td><?php echo $value['server_id']; ?></td>
                            <td><?php echo $value['_id']['role_id']; ?></td>
                            <td><?php echo $value['count']; ?></td>
                        </tr>
                        <?php
                           $y_data[] = $value['count'];
                            $x_key[] = $key+1;
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $l_data = json_encode($x_key);
                $x_data = json_encode($resultArr);

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
                        name: '排名',
                        type: 'category',
                        boundaryGap: true,
                        data:<?php echo $l_data;?>
                    }
                ],

                yAxis: [
                    {
                        name: '付费(￥)',
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
                            $tmp[] = $dts['count'];
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
<?php endif;?>

</script>
