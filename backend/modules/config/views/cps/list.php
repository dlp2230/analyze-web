<?php
$this->pageJs('config/channel.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                游戏列表
                <span class="pull-right cps-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_CPS_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>分包id</th>
                            <th>渠道id</th>
                            <th>分包名称</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item['cps_id']; ?></td>
                                <td><?php echo $channel_list[$item['channel_id']].' | '.$item['channel_id']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm cps-upd  need-check"
                                       data-id="<?php echo $item['cps_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_CPS_UPD');?>">编辑</a>
                                    <a href="#" class="btn btn-danger btn-sm cps-del  need-check"
                                       data-id="<?php echo $item['cps_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_CPS_DEL');?>">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php echo $this->pager; ?>
                </div>
            </div>
        </div>
    </div>
</div>
