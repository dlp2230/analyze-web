<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>F</b>ounq</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Founq</b>.v1</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="">
                <ul class="nav navbar-nav">
                    <?php
                    if (is_array($this->_menu['0']) && count($this->_menu['0']) > 0) {
                        foreach ($this->_menu['0'] as $menu):
                            ?>
                            <li class="<?php echo (!is_null($this->_activeMenu) && in_array($menu['id'], $this->_activeMenu)) ? 'active' : ''; ?>">
                                <a href="<?php echo $menu['route']; ?>"><span
                                        class="<?php echo $menu['icon']; ?>"></span> <?php echo $menu['menu_name']; ?>
                                </a></li>
                            <?php
                            if (!is_null($this->_activeMenu) && in_array($menu['id'], $this->_activeMenu)) {
                                $leftMenuId = $menu['id'];
                            }
                        endforeach;
                    }
                    ?>
                </ul>
            </div>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?php echo $this->userinfo->name; ?><i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/config/admin/edit-admin"
                                       class="btn btn-default btn-flat">编辑信息</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/system/site/logout/"
                                       class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <?php if ($this->toggle == 'gsc'): ?>
                <input id="menuType" value="gsc" type="hidden">
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <span class="input-group-addon" id="game_id">产品</span>
                        <select class="form-control" id="select_menu_game_id"
                                aria-describedby="game_id">
                            <option value="">请选择</option>
                            <?php
                            if (isset($this->_selectMenu['games'])) {
                                foreach ($this->_selectMenu['games'] as $game_id => $name):
                                    ?>
                                    <option
                                        value="<?php echo $game_id; ?>" <?php if (isset($this->_selectMenu['_game']) && $this->_selectMenu['_game'] == $game_id) echo "selected"; ?>><?php echo $name; ?></option>
                                    <?php
                                endforeach;
                            } ?>
                        </select>
                    </div>
                </form>
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <span class="input-group-addon" id="z_h">专混</span>
                        <select class="form-control" id="select_menu_server_type"
                                aria-describedby="z_h">
                            <option value="">请选择</option>
                            <?php
                            if (isset($this->_selectMenu['server_types'])) {
                                foreach ($this->_selectMenu['server_types'] as $type_id => $type_name):
                                    ?>
                                    <option
                                        value="<?php echo $type_id; ?>" <?php if (isset($this->_selectMenu['_server_type']) && $this->_selectMenu['_server_type'] == $type_id) echo "selected"; ?>><?php echo $type_name; ?></option>
                                    <?php
                                endforeach;
                            } ?>
                        </select>
                    </div>
                </form>
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <span class="input-group-addon" id="z_h">区服</span>
                        <select class="form-control" id="select_menu_server" aria-describedby="z_h">
                            <option value="">请选择</option>
                            <?php
                            if (isset($this->_selectMenu['servers'])) {
                                foreach ($this->_selectMenu['servers'] as $sid => $server_name):
                                    ?>
                                    <option
                                        value="<?php echo $sid; ?>" <?php if (isset($this->_selectMenu['_server']) && $this->_selectMenu['_server'] == $sid) echo "selected"; ?>><?php echo $server_name; ?></option>
                                    <?php
                                endforeach;
                            } ?>
                        </select>
                    </div>
                </form>
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <span class="input-group-addon" id="z_h">平台</span>
                        <select class="form-control" id="select_menu_channel" aria-describedby="z_h">
                            <option value="">全部</option>
                            <?php
                            if (isset($this->_selectMenu['channels'])) {
                                foreach ($this->_selectMenu['channels'] as $channel_id => $channel_name):
                                    ?>
                                    <option
                                        value="<?php echo $channel_id; ?>" <?php if (isset($this->_selectMenu['_channel']) && $this->_selectMenu['_channel'] == $channel_id) echo "selected"; ?>><?php echo $channel_name; ?></option>
                                    <?php
                                endforeach;
                            } ?>
                        </select>
                    </div>
                </form>
            <?php elseif ($this->toggle == 'gc'): ?>
                <input id="menuType" value="gc" type="hidden">
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <span class="input-group-addon" id="game_id">产品</span>
                        <select class="form-control" id="select_menu_game_id"
                                aria-describedby="game_id">
                            <option value="">请选择</option>
                            <?php
                            if (isset($this->_selectMenu['games'])) {
                                foreach ($this->_selectMenu['games'] as $game_id => $name):
                                    ?>
                                    <option
                                        value="<?php echo $game_id; ?>" <?php if (isset($this->_selectMenu['_game']) && $this->_selectMenu['_game'] == $game_id) echo "selected"; ?>><?php echo $name; ?></option>
                                    <?php
                                endforeach;
                            } ?>
                        </select>
                    </div>
                </form>
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <span class="input-group-addon" id="z_h">平台</span>
                        <select class="form-control" id="select_menu_channel" aria-describedby="z_h">
                            <option value="">全部</option>
                            <?php
                            if (isset($this->_selectMenu['channels'])) {
                                foreach ($this->_selectMenu['channels'] as $channel_id => $channel_name):
                                    ?>
                                    <option
                                        value="<?php echo $channel_id; ?>" <?php if (isset($this->_selectMenu['_channel']) && $this->_selectMenu['_channel'] == $channel_id) echo "selected"; ?>><?php echo $channel_name; ?></option>
                                    <?php
                                endforeach;
                            } ?>
                        </select>
                    </div>
                </form>
            <?php endif; ?>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <?php
                if (isset($this->_menu[$leftMenuId])) {
                    if (is_array($this->_menu[$leftMenuId]) && count($this->_menu[$leftMenuId]) > 0) {
                        foreach ($this->_menu[$leftMenuId] as $menu):
                            if (isset($this->_menu[$menu['id']])) {
                                if (is_array($this->_menu[$menu['id']]) && count($this->_menu[$menu['id']]) > 0) {
                                    if (in_array($menu['id'], $this->_activeMenu)) {
                                        $_dashBorad1 = $menu['menu_name']; ?>
                                        <li class="treeview active">
                                    <?php } else { ?>
                                        <li class="treeview">
                                    <?php } ?>
                                    <a href="<?php echo $menu['route']; ?>">
                                        <i class="fa  fa-plus"></i>
                                        <span><?php echo $menu['menu_name']; ?></span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php
                                        foreach ($this->_menu[$menu['id']] as $childMenu):
                                            if (in_array($childMenu['id'], $this->_activeMenu)) {
                                                $_dashBorad2 = $childMenu['menu_name']; ?>
                                                <li class="active">
                                            <?php } else { ?>
                                                <li>
                                            <?php } ?>
                                            <a href="<?php echo $childMenu['route']; ?>"><i
                                                    class="fa fa-minus"></i> <?php echo $childMenu['menu_name']; ?></a>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                    <?php
                                }
                            } else {
                                if (in_array($menu['id'], $this->_activeMenu)) {
                                    $_dashBorad1 = $menu['menu_name']; ?>
                                    <li class="active">
                                <?php } else { ?>
                                    <li>
                                <?php } ?>
                                <a href="<?php echo $menu['route']; ?>">
                                    <i class="fa fa-minus"></i> <span><?php echo $menu['menu_name']; ?></span>
                                </a>
                                </li>
                            <?php }
                        endforeach;
                    }
                } else {
                    ?>
                    <li class="">
                        <a href="">
                            <i class="fa fa-edit"></i> <span>欢迎</span>
                        </a>
                    </li>
                <?php }
                ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php if (isset($_dashBorad1)) echo $_dashBorad1; ?>
                <small><?php if (isset($_dashBorad2)) echo $_dashBorad2; ?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php echo $content ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2015-2020 <a href="http://www.founq.com">上海方趣网络科技有限公司</a>.</strong> All rights
        reserved.
    </footer>
</div>


<script type="text/javascript">
    var perm = <?php echo \backend\libraries\CheckPerm::createJson();?>;
    var search_data = <?php if(isset($this->_search_data)){echo $this->_search_data;}else{echo '[]';} ?>;
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

}