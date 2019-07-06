<?php if(!empty($resultArr)):?>
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
                        <th>充值次数</th>
                        <th>付费人数(人)</th>
                        <th>比例(%)</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php
                    $tmp_u_1 = [];
                    $tmp_n_1 = [];
                    $tmp_r_1 = [];
                    if(!empty($resultArr)){
                        foreach ($resultArr as $theinfo) {
                            $tmp_u_1[] = $theinfo['total'];
                            $tmp_n_1[] = $theinfo['num'];

                        }
                    }

                    ?>
                    <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo $value['num']; ?></td>
                            <td><?php echo count($value['reg_num']); ?></td>
                            <?php
                               if($value['num'] == 0){
                                   $value['svg'] = '0.00';
                               }else{
                                   $value['svg'] = round(count($value['reg_num'])/$value['total']*100,2);
                               }
                                   $tmp_r_1[] = array('name' => $value['num'], 'value' => round(count($value['reg_num']) / $value['total'] * 100, 2));
                            ?>
                            <td><?php echo $value['svg']; ?></td>
                        </tr>
                        <?php
                           $y_data[] = $value['svg'];

                        ?>
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
                暂无数据
            </div>
        </div>
    </div>
<?php endif;?>
<script type="text/javascript">
   <?php
      if(!empty($resultArr)){
   ?>
   require.config({
       paths: {
           echarts: '<?php echo Yii::$app->params['returnEcharts'];?>'
       }
   });
   require(
       [
           'echarts',
           'echarts/chart/pie',
           'echarts/chart/funnel'
       ],
       function (ec) {
           var chart_1 = ec.init(document.getElementById('playerloss'));
           var option = {
               title: {
                   text: '玩家首付次数',
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
                           title: '玩家首付次数',
                           type: 'png'
                       }
                   }
               },
               calculable: true,
               series: [
                   {
                       name: '付费玩家',
                       type: 'pie',
                       radius: '55%',
                       center: ['50%', '60%'],
                       data:<?php echo json_encode($tmp_r_1);?>
                   }
               ]
           };
           chart_1.setOption(option);
       });
   <?php
   }
      ?>

</script>
