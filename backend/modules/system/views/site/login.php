<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;


//$this->pageCss('system/login/login.css');

$this->pageJs('system/login.js');
?>

<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>Founq-analyze-web</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg <?php echo isset($view['error']) ? 'text-red' : ''; ?> "><?php echo isset($view['error']) ? $view['error'] : 'Sign in to start your session'; ?></p>

        <form method="post">
            <div class="form-group has-feedback <?php echo isset($view['error']) ? 'has-error' : ''; ?>">
                <input type="email" name="email" class="form-control" placeholder="邮箱"
                       value="<?php echo isset($view['email']) ? $view['email'] : ''; ?>"/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback <?php echo isset($view['error']) ? 'has-error' : ''; ?>">
                <input type="password" name="password" class="form-control" placeholder="密码"
                       value="<?php echo isset($view['password']) ? $view['password'] : ''; ?>"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback <?php echo isset($view['error']) ? 'has-error' : ''; ?>">
                <input type="text" name="login_code" class="form-control" placeholder="验证码"
                        value="" style="width: 150px; float: left;" />

                <img src="/system/site/create-code/" style="float: left; margin-left: 40px; cursor:pointer;;" onclick="this.src = '/system/site/create-code/?num=' + new Date().getTime();"/>
            </div>

            <div class="row" style="clear: both; margin-top: 62px;">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input name="rember"
                                   value="checked" <?php echo isset($view['rember']) ? $view['rember'] : ''; ?>
                                   type="checkbox"> 7天免登录
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登 录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->



