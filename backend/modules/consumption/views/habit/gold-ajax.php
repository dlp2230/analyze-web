<?php if($is_display == 1):?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel">
                <div id="div_chart_1" style="height: 500px"></div>
            </div>
            <div class="panel">
                <div id="echarts" class="center" style="height:500px"></div>
            </div>
        </div>
    </div>
    <?php
    $game_id = Yii::$app->session->get('game_id');
    $typesArr = isset(Yii::$app->params['consumptionType_'.$game_id])?Yii::$app->params['consumptionType_'.$game_id]:[];
    $datamenu = '金币消耗';
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
                            <th>消费途径</th>
                            <th>消费总计</th>
                            <th width="250">比例(%) (注:<span class="text-red">保留2位小数 四舍五入</span>)</th>
                        <tr>
                        </thead>
                        <tbody>
                        <?php
                        $tmp_u_1 = [];
                        $tmp_n_1 = [];
                        $tmp_r_1 = [];
                        $acts = [];
                        $dtss = [];
                        $chart_data_1 = array();
                        $total = 0;
                        $newArr = [];
                        if(!empty($resultArr)){
                            foreach ($resultArr as $kts=>$theinfo) {
                                $total += array_sum(array_column($theinfo,'count'));
                                $dts = $kts;
                                if(!empty($theinfo)){
                                    foreach ($theinfo as $key=>$item) {
                                        $act = $item['CP_type'];
                                        if($act) {
                                            if (isset($typesArr[$act])) {
                                                $act = $typesArr[$act];
                                            }
                                        } else {
                                            $act = '未知';
                                        }
                                        $cnt = $item['count'];
                                        if (!in_array($act, $acts)) {
                                            $acts[] = $act;
                                        }
                                        if (!in_array($act, $acts)) {
                                            $acts[] = $act;
                                        }
                                        if (!in_array($dts, $dtss)) {
                                            $dtss[] = $dts;
                                        }
                                        // 数组 = 时间+类型
                                        $chart_data_1[$dts][$act] = $cnt;
                                        // 存在就相加
                                        if(isset($newArr[$item['CP_type']])){
                                            $tmp_n_1[] = isset($typesArr[$item['CP_type']])?$typesArr[$item['CP_type']]:$item['CP_type'];
                                            $newArr[$item['CP_type']]['count'] += $theinfo[$key]['count'];
                                        }else{
                                            $newArr[$item['CP_type']] = [
                                                'CP_type'=> $theinfo[$key]['CP_type'],
                                                'count'=> $theinfo[$key]['count'],
                                            ];
                                        }

                                    }
                                }else{
                                    $dtss[] = $kts;
                                    $chart_data_1[$kts] = 0;
                                }
                            }

                           if($total == 0 ){
                               $chart_data_1 = [];
                               $newArr = [];
                           }else{
                               $tmp_u_1[] = $total;
                               $tmp_n_1 = array_unique($tmp_n_1);
                               $l_data_2 = json_encode($acts);

                               $x_data_2 = json_encode($dtss);
                           }

                        }
                        ?>
                        <?php if(isset($newArr)) foreach ($newArr as $key=>$value): ?>
                            <tr>
                                <td><?php echo isset($typesArr[$value['CP_type']])?$typesArr[$value['CP_type']]:$value['CP_type']; ?></td>
                                <td><?php echo $value['count']; ?></td>
                                <?php
                                if($value['count'] == 0){
                                    $value['svg'] = '0.00';
                                }else{
                                    $value['svg'] = round($value['count']/$total*100,2);
                                }
                                $tmp_r_1[] = array('name' => isset($typesArr[$value['CP_type']])?$typesArr[$value['CP_type']]:$value['CP_type'], 'value' => $value['svg']);
                                ?>
                                <td><?php echo $value['svg'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php else:?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="icheckbox_flat-red">暂无数据</div>
            </div>
        </div>
    </div>
<?php endif;?>
<script type="text/javascript">
    <?php
    if(!empty($newArr)){
    ?>
    require.config({
        paths: {
            echarts: '<?php echo Yii::$app->params['returnEcharts'];?>'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],
        function (ec) {
            var chart_1 = ec.init(document.getElementById('echarts'));
            var option = {
                title: {
                    text: '消费途径',
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a}<br/>{b}:{c}({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data:<?php echo json_encode($tmp_n_1); ?>
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
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '30%',
                                    funnelAlign: 'left',
                                    max:<?php echo max($tmp_u_1); ?>
                                }
                            }
                        },
                        restore: {
                            show: true
                        },
                        saveAsImage: {
                            show: true,
                            title: '消费途径',
                            type: 'png'
                        }
                    }
                },
                calculable: true,
                series: [
                    {
                        name: '消费途径',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data:<?php echo json_encode($tmp_r_1);?>
                    }
                ]
            };
            chart_1.setOption(option);

            /*
             * 2
             * **/
            var chart_2 = ec.init(document.getElementById('div_chart_1'));
            var option_2 = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:<?php echo $l_data_2; ?>
                },
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    x: 'right',
                    y: 'center',
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
                            title: '图片',
                            type: 'png'
                        }
                    }
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data:<?php echo $x_data_2;?>
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    <?php
                    for($i = 0; $i < count($acts); $i ++) {
                    $act = $acts[$i];
                    ?>
                    {
                        name: '<?php echo $act;?>',
                        type: 'line',
                        stack: '总量',
                        data:
                        <?php
                        $tmp = array();
                        foreach($dtss as $dts) {
                            if(isset($chart_data_1[$dts][$act])) {
                                $tmp[] = intval($chart_data_1[$dts][$act]);
                            } else {
                                $tmp[] = 0;
                            }
                        }
                        echo json_encode($tmp);
                        ?>
                    }
                    <?php
                    if($i != count($acts) - 1) {
                        echo ',';
                    }
                    }
                    ?>
                ]
            };
            chart_2.setOption(option_2);

        });
    <?php
    }
    ?>

</script>
