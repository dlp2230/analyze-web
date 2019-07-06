<?php
$this->pageJs('config/menu.js');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button data-level="<?php echo $level; ?>" data-pid="<?php echo $pid; ?>"
                        class="btn btn-primary menu-add need-check"
                        data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MENU_ADD'); ?>">
                    新增1级菜单
                </button>
                <div style="display: inline-block"><span class="text-red"><strong>注:</strong>1级菜单位于系统的头部!</span></div>

            </div>

            <div class="panel-body">
                <div class="table-responsive" id="menu-list">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>菜单名称</th>
                            <th>菜单图标</th>
                            <th>路由配置</th>
                            <th>权限标识</th>
                            <th>排序</th>
                            <th>编辑</th>
                            <th>删除</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($list as $menu) {
                            ?>
                            <tr>
                                <td><?php echo $menu['menu_name']; ?></td>
                                <td><span class="<?php echo $menu['icon']; ?>"></span></td>
                                <?php if ($menu['is_menu']): ?>
                                    <td>
                                        <a href="<?php echo '/config/menu/list?level=2&pid=' . $menu['id']; ?>"
                                           class="btn btn-success btn-sm need-check" role="button"
                                           data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MENU_LIST'); ?>">管理子菜单</a>
                                    </td>
                                <?php else: ?>
                                    <td><?php echo $menu['route']; ?></td>
                                <?php endif; ?>

                                <td><?php echo $menu['menu_perm_id']; ?></td>
                                <td><?php echo $menu['sort']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm menu-upd need-check"
                                       data-level="<?php echo $level; ?>" data-id="<?php echo $menu['id']; ?>"
                                       role="button"
                                       data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MENU_UPD'); ?>">编辑</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm menu-del need-check"
                                       data-id="<?php echo $menu['id']; ?>" role="button"
                                       data-permid="<?php echo \backend\libraries\CheckPerm::createItem('CONFIG_MENU_DEL'); ?>">删除</a>
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