<?php
$this->pageJs('config/secretkey.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                游戏秘钥
                <span class="pull-right secretkey-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SECRETKEY_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>游戏ID</th>
                            <th>key</th>
                            <th>游戏名称</th>
                            <th>状态</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item['game_id']; ?></td>
                                <td><?php echo $item['private_key']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php
                                    echo $item['status']==1?"开启":"禁用";
                                    ?>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm phatform-upd  need-check"
                                       data-id="<?php echo $item['game_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SECRETKEY_UPD');?>">编辑</a>
                                    <a href="#" class="btn <?php echo $item['status']==1?'btn-danger':'btn-success'; ?> btn-sm phatform-status need-check"
                                       data-id="<?php echo $item['game_id']; ?>" data-status="<?php echo $item['status']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SECRETKEY_STATUS');?>">
                                        <?php echo $item['status']==1? '禁用':'启用';?>
                                    </a>
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