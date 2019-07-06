<?php
$this->pageJs('config/perm.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                模块列表
                <span class="pull-right module-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MODULE_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>完整path</th>
                            <th>权限</th>
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
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm module-upd  need-check"
                                       data-id="<?php echo $item['id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MODULE_UPD');?>">编辑</a>
                                    <a href="#" class="btn btn-danger btn-sm module-del  need-check"
                                       data-id="<?php echo $item['id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MODULE_DEL');?>">删除</a>
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