<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/5
 * Time: 18:14
 */

namespace backend\libraries;


use common\models\AdminGroupPerm;
use yii\helpers\ArrayHelper;

class CheckPerm
{
    static $needCheck = [];

    public static function createItem($perm)
    {
        if (array_key_exists($perm, self::$needCheck)) {
            return self::$needCheck[$perm];
        }
        //生成随机数
        $key = rand(10, 99);
        $key .= count(self::$needCheck);
        self::$needCheck[$perm] = $key;
        return $key;
    }

    public static function createJson()
    {
        $needCheck = array_keys(self::$needCheck);
        $result = AdminGroupPerm::find()->where(['in', 'perm_id', $needCheck])->andWhere('ag_id =' . \Yii::$app->session->get('ag_id'))->all();
        $output = [];
        foreach (ArrayHelper::getColumn($result, 'perm_id') as $perm) {
            $output[] = self::$needCheck[$perm];
        }
        return json_encode($output, JSON_UNESCAPED_UNICODE);
    }
}