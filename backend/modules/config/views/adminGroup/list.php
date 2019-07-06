<?php
$this->pageJs('config/user.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                用户组列表
                <span class="pull-right userGroup-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMINGROUP_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="adminGroup-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>用户组id</th>
                            <th>用户组名</th>
                            <th>描述</th>
                            <th>类型</th>
                            <th>权限配置</th>
                            <th>修改</th>
                            <th>删除</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $userGroup) {
                            ?>
                            <tr>
                                <td><?php echo $userGroup['ag_id']; ?></td>
                                <td><?php echo $userGroup['name']; ?></td>
                                <td><?php echo $userGroup['description']; ?></td>
                                <td><?php echo ($userGroup['type'] == 1) ? '超级' : '普通'; ?></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm userGroup-setting need-check"
                                       data-id="<?php echo $userGroup['ag_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMINGROUP_SETTING');?>">权限配置</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm userGroup-upd need-check"
                                       data-id="<?php echo $userGroup['ag_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMINGROUP_UPD');?>">编辑</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm userGroup-del need-check"
                                       data-id="<?php echo $userGroup['ag_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMINGROUP_DEL');?>">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php echo $this->pager ?>
                </div>
            </div>
        </div>
    </div>
</div>