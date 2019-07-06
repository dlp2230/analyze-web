<?php

namespace common\helpers;

use yii\base\Object;
use yii;

class MongoHelper extends Object
{

    public static $dbPrefix = 'game_';

    //切换mongo连接
    public static function setMongo($game_id)
    {
        Yii::$app->get('mongodb')->setDefaultDatabaseName(self::$dbPrefix . $game_id);
    }
}