<?php
$this->pageJs('config/game.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                游戏列表
                <span class="pull-right game-add need-check" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_GAME_ADD');?>"><i class="glyphicon glyphicon-plus"></i> 新增</span>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>游戏ID</th>
                            <th>游戏名称</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item['game_id']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm game-upd  need-check"
                                       data-id="<?php echo $item['game_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_GAME_UPD');?>">编辑</a>
                                    <a href="#" class="btn btn-danger btn-sm game-del  need-check"
                                       data-id="<?php echo $item['game_id']; ?>" role="button" data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_GAME_DEL');?>">删除</a>
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