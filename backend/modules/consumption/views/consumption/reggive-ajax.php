
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
                        <th>消费充值币额度</th>

                        <th>消费赠送币额度</th>
                        <th>总额度</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($LossArr)) foreach ($LossArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value['CP_true_num']; ?></td>

                            <td><?php echo $value['CP_false_num']; ?></td>
                            <td><?php echo $value['CP_price']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
