<?php
$this->pageJs('config/perm.js');
?>
<div class="row">
    <div class="col-lg-12">
        <form action="" method="get" class="form-inline well" role="form" id="">
           <div class="form-group">
                <lable>名称：</lable>
                <input type="text" value="<?php echo Yii::$app->request->get('name')?Yii::$app->request->get('name'):'';?>"  class="form-control" id="name" name="name" placeholder="请输入名称">
            </div>
            <button type="submit" class="btn btn-sm btn-info">检索</button>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading">
                权限列表
                <span class="pull-right perm-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_PERM_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>完整path</th>
                            <th>权限</th>
                            <th>所属权限组</th>
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
                                    <a href="#" class="btn btn-warning btn-sm perm-upd need-check"
                                       data-id="<?php echo $item['id']; ?>" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_PERM_UPD');?>" role="button">编辑</a>
                                    <a href="#" class="btn btn-danger btn-sm perm-del need-check"
                                       data-id="<?php echo $item['id']; ?>" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_PERM_DEL');?>" role="button">删除</a>
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