<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'layoutPath' => '@app/views/layouts',
    'layout' => 'main.php',
    'defaultRoute' => 'system',
    'language' => "zh-CN",
    'modules' => [
        'system' => ['class' => 'backend\modules\system\Module', 'defaultRoute' => 'index'],
        'config' => ['class' => 'backend\modules\config\Module'],
        'overview' => ['class' => 'backend\modules\overview\Module'],
        'gameuser' => ['class' => 'backend\modules\gameuser\Module'],
        'pay' => ['class' => 'backend\modules\pay\Module'],
        'consumption' => ['class' => 'backend\modules\consumption\Module'],
        'channel' => ['class' => 'backend\modules\channel\Module'],
    ],
    'components' => [
        'view' => ['class' => 'backend\libraries\base\View'],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'system/error/error',
        ],
    ],
    'params' => $params,
];
