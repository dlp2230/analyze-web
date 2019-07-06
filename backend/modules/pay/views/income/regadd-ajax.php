<?php
$this->pageJs('config/perm.js');
 if(!empty($resultArr)){
  $datamenu = 'GM赠送币';

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
                        <th>角色UID</th>
                        <th>货币量</th>
                         <th>获得途径</th>
                    <tr>
                    </thead>
                    <tbody>
                    <?php if(isset($resultArr)) foreach ($resultArr as $key=>$value): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i:s',$value['timestamp']); ?></td>
                            <td><?php echo $value['role_id']; ?></td>
                            <td><?php echo $value['CP_true_num']+$value['CP_false_num']; ?></td>
                            <td><?php echo $value['CP_type']; ?></td>


                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
             </div>
        </div>
    </div>
    <?php echo $this->pager; ?>
</div>
<?php }else {
?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            暂无数据
        </div>
        </div>
    </div>
      <?php
  }
?>
