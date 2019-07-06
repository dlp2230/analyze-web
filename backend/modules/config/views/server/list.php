<?php
$this->pageJs('config/server.js');
?>
<form action="/config/server/list" method="get" class="form-inline well" role="form" id="search_form">
    <div class="form-group">
        <label for="game_id">游戏名称：</label>
        <div class="form-group">
            <select class="form-control select1" id="game_id" name="game_id">
                <option value=''>所有</option>
                <?php foreach ($game_list as $k => $v): ?>
                    <option value="<?php echo $k ?>"><?php echo $v ?> | <?php echo $k; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="server_type">服务器类型：</label>
        <select class="form-control select1" id="server_type" name="server_type">
            <option value=''>所有</option>
            <?php foreach ($server_type as $k => $v): ?>
                <option value="<?php echo $k ?>"><?php echo $v ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-info">检索</button>
</form>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                服务器列表
                <span class="pull-right server-add need-check"
                      data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SERVER_ADD'); ?>"><i
                        class="glyphicon glyphicon-plus"></i> 新增</span>
                <span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
             <?php  if(!empty($params['server_type = '])){ echo '<span class="pull-right server-batchupd  need-check" data-permid="'.\backend\libraries\CheckPerm::createItem('CONFIG_SERVER_BATCHUPD').'"><i class="glyphicon glyphicon-pencil"></i> 批量修改渠道</span>';} ?>
            </div>

            <div class="panel-body">
                <div class="table-responsive" id="perm-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <?php  if(!empty($params['server_type = '])){ echo '<th width="50px"><input style="margin-left:10px;" id="check" type="checkbox"></th>';}?>
                            <th>服务器id</th>
                            <th>服务器名称</th>
                            <th>游戏名称</th>
                            <th>服务器类型</th>
                            <th>开服时间</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $item) {
                            ?>
                            <tr>
                                <?php  if(!empty($params['server_type = '])){ echo'<td><input style="margin-left:10px;" type="checkbox" data-sid="'.$item['sid'].'" class="server_id"></td>';}?>
                                <td><?php echo $item['sid']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $game_list[$item['game_id']]; ?></td>
                                <td><?php echo $server_type[$item['server_type']]; ?></td>
                                <td><?php echo $item['open_server_time']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm server-upd  need-check"
                                       data-id="<?php echo $item['sid']; ?>" role="button"
                                       data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SERVER_UPD'); ?>">编辑</a>
<!--                                    --><?php
//                                      if($item['open_server_time'] >= date('Y-m-d H:i:s')) {
//                                          ?>
                                          <a href="#" class="btn btn-danger btn-sm server-clear-file  need-check"
                                             data-id="<?php echo $item['sid']; ?>"
                                             data-gameid="<?php echo $item['game_id']; ?>"
                                             data-openservertime="<?php echo $item['open_server_time']; ?>"
                                             role="button"
                                             data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SERVER_CLEARFILE'); ?>">清档</a>
<!--                                          --><?php
//                                      }else {
//                                          ?>
<!--                                          <a type="button" class="btn btn-danger btn-sm" disabled="disabled">清档</a>-->
<!--                                          --><?php
//                                      }
//                                    ?>
                                    <a href="#" class="btn btn-danger btn-sm server-del  need-check"
                                       data-id="<?php echo $item['sid']; ?>" role="button"
                                       data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_SERVER_DEL'); ?>">删除</a>
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