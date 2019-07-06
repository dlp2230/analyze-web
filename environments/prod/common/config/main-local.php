<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=rm-uf6n9435u8044w7c2.mysql.rds.aliyuncs.com;dbname=yiianalyze',
            'username' => 'analyze_root',
            'password' => 'FQ_Analyze_1b25e3-',
            'charset' => 'utf8',
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://root:FQ_Analyze_e8fdfd@dds-uf62611b32e3d7d41.mongodb.rds.aliyuncs.com:3717,dds-uf62611b32e3d7d42.mongodb.rds.aliyuncs.com:3717/admin',
            'options' => ['replicaSet' => 'mgset-1327983']
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'password'=>null,
            'database' => 0,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
