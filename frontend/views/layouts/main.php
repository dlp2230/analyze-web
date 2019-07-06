<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?=Html::encode($this->title)  ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <!--公共头开始-->
    <div class="row" style="height: 60px;"></div>
    <!--公共头结束-->
    <div class="row">
        <div class="col-md-2"></div>
    <div class="container col-md-8" style="margin:0 auto;background-color:#fff;">

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
        <div class="col-md-2"></div>
   </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
