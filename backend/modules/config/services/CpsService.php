<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Cps;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class CpsService extends Service
{
    public function getList($start, $length, $where)
    {
        return Cps::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Cps::find()->where($where)->count();
    }


}