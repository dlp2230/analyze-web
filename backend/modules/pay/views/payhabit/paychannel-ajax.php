<?php if(!empty($resultArr)):?>
 <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            渠道付费
        </div>

        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-hover ">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>渠道名称</th>
                        <th>充值总额</th>
                        <th>充值人数</th>
                        <th>渠道占比(%)</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                        <?php
                         if(!empty($value)){
                              $total = $value['paytoday'];
                              unset($value['paytoday']);

                             foreach ($value as $item){
                                 echo '<tr>';
                                 echo '<td>'.$key.'</td>';
                                 $channelName = isset($channelArr[$item['_id']['channel_id']]) ? $channelArr[$item['_id']['channel_id']] : $item['_id']['channel_id'];
                                 echo '<td>'.$channelName.'</td>';
                                 echo '<td>'.$item['total'].'</td>';
                                 echo '<td>'.$item['role_nums'].'</td>';
                                 if($item['total'] == 0 || $total == 0){
                                     $svg = 0.00;
                                 }else{
                                     $svg = round($item['total']/$total*100,2);
                                 }
                                 echo '<td>'.$svg.'</td>';
                                 echo '</tr>';
                             }
                          }

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
