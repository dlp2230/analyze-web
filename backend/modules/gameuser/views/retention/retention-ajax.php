<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="retention" class="center" style="height:300px"></div>
        </div>
    </div>
</div>
<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                角色留存
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>新增角色数</th>
                                <?php if(isset($retentionDay)) foreach ($retentionDay as $retention): ?>
                                    <?php
                                      $newRetentionDay[] = $retention.'日留存';
                                    ?>
                                    <th><?php echo  $retention?>日</th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($retrntion_arr)) foreach (array_reverse($retrntion_arr) as $key=>$value): ?>
                            <tr>
                                <td><?php echo $key;?></td>
                                <td><?php echo $value['total'];
                                     unset($value['total']);
                                    ?></td>
                                <?php foreach ($value as $v): ?>
                                    <?php
                                      if($v=='0.00'){
                                          echo '<td>-</td>';
                                      }else{
                                          echo '<td>'.$v.'%</td>';
                                      }
                                    ?>

                                <?php endforeach; ?>
                            </tr>
                            <?php
                            $dtss[] = $key;

                            ?>
                        <?php endforeach; ?>
                         <?php
						  $x_data = json_encode(array_reverse($dtss));

                         $l_data = json_encode($newRetentionDay);
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
               
                var chart_1 = ec.init(document.getElementById('retention'));
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
                                title: '留存分析',
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
                            name: '比例(%)',
                            type: 'value'
                        }
                    ],
                    series: [
                        <?php
                        for($i = 0; $i < count($retentionDay); $i ++) {
                        $act = $retentionDay[$i];
                        ?>
                        {
                            name: '<?php echo $act;?>'+'日留存',
                            type: 'line',
                            data:
                            <?php
                            $tmp = array();
                            foreach($dtss as $dts) {
                                if(isset($retrntion_arr[$dts])) {
                                    $tmp[] = $retrntion_arr[$dts][$act];
                                } else {
                                    $tmp[] = 0;
                                }
                            }
                            echo json_encode(array_reverse($tmp));
                            ?>
                        }
                        <?php
							if($i != count($retentionDay) - 1) {
								echo ',';
							}
                        }
                        ?>


                    ]
                };
                chart_1.setOption(option);
			});
      
		
    </script>


