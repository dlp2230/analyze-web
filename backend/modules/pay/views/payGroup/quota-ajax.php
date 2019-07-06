<?php if(!empty($resultArr)):?>
    <?php
  $datamenu = '付费用户数额度分布';

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
                        <th>时间</th>
                        <th>￥(1-10)</th>
                        <th>￥(11-100)</th>
                        <th>￥(101-500)</th>
                        <th>￥(500-1000)</th>
                        <th>￥(1000以上)</th>

                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value['one']; ?></td>
                            <td><?php echo $value['ten']; ?></td>
                            <td><?php echo $value['one_hundred']; ?></td>
                            <td><?php echo $value['five_hundred']; ?></td>
                            <td><?php echo $value['one_thousand']; ?></td>
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
               <div>暂无数据</div>
            </div>
        </div>
    </div>
<?php endif;?>
