<?php
$this->pageJs('config/perm.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                权限组列表
                <span class="pull-right permGroup-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_PERMGROUP_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="permGroup-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>权限组</th>
                            <th>权限</th>
                            <th>所属模块</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['perm_id']; ?></td>
                                <td><?php echo $item['pid']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm permGroup-upd need-check"
                                       data-id="<?php echo $item['id']; ?>" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_PERMGROUP_UPD');?>" role="button">编辑</a>
                                    <a href="#" class="btn btn-danger btn-sm permGroup-del need-check"
                                       data-id="<?php echo $item['id']; ?>" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_PERMGROUP_DEL');?>" role="button">删除</a>
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