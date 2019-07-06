<?php
//全局函数
require(__DIR__ . '/../utils.php');
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('back-resources', dirname(dirname(__DIR__)) . '/backend/resources');
Yii::setAlias('front-resources', dirname(dirname(__DIR__)) . '/frontend/resources');

