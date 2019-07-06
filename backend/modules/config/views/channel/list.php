<?php
$this->pageJs('config/channel.js');
?>
<div class="row">
    <div class="col-lg-12">
        <form action="" method="get" class="form-inline well" role="form" id="">
            <div class="form-group">
                <lable>名称/渠道ID：</lable>
                <input type="text" value="<?php echo Yii::$app->request->get('name')?Yii::$app->request->get('name'):'';?>"  class="form-control" id="name" name="name" placeholder="请输入名称/渠道ID">
            </div>
            <button type="submit" class="btn btn-sm btn-info">检索</button>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading">
                渠道列表
                <span class="pull-right channel-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_CHANNEL_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>渠道id</th>
                            <th>渠道名称</th>
                            <th>渠道类别</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($list)) {
                            foreach ($list as $item) {
                                ?>
                                <tr>
                                    <td><?php echo $item['channel_id']; ?></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $device_type[$item['type']] ?></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm channel-upd  need-check"
                                           data-id="<?php echo $item['channel_id']; ?>" role="button"
                                           data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_CHANNEL_UPD'); ?>">编辑</a>
                                        <a href="#" class="btn btn-danger btn-sm channel-del  need-check"
                                           data-id="<?php echo $item['channel_id']; ?>" role="button"
                                           data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_CHANNEL_DEL'); ?>">删除</a>
                                    </td>
                                </tr>
                            <?php }
                        }else {
                            ?>
                            <tr><td colspan="4" class="text-red">暂无数据!!!</td></tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php echo $this->pager; ?>
                </div>
            </div>
        </div>
    </div>
</div>