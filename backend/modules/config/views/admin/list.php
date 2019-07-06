<?php
$this->pageJs('config/user.js');

?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                用户组列表
                <span class="pull-right user-add  need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMIN_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span><span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span class="pull-right user-batchupd  need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMIN_BATCHUPD');?>"><i class="glyphicon glyphicon-pencil"></i> 批量修改游戏</span>
            </div>
            <div class="panel-body">
                <div class="table-responsive" id="user-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>用户id</th>
                            <th>用户名</th>
                            <th>登陆账号</th>
                            <th>所属用户组</th>
                            <th>用户电话</th>
                            <th>状态</th>
                            <th>修改</th>
                            <th>删除</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $user) {
                            ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><span class="<?php echo $user['ag_id'] == 1 ? 'text-red':'';?>"><?php echo $userGroup[$user['ag_id']]; ?></span></td>
                                <td><?php echo $user['mobile']; ?></td>
                                <td><?php echo $user['status'] == 1 ? "正常启用" : "已禁用"; ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm user-upd  need-check"
                                       data-id="<?php echo $user['id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMIN_UPD');?>">编辑</a>
                                    <a href="#" class="btn btn-info btn-sm user-reset  need-check"
                                       data-id="<?php echo $user['id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMIN_RESET');?>">重置密码</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm user-del  need-check"
                                       data-id="<?php echo $user['id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_ADMIN_DEL');?>">删除</a>
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