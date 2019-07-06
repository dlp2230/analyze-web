<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Module;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class ModuleService extends Service
{
    public function getList($start, $length, $where)
    {
        return Module::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Module::find()->where($where)->count();
    }

    //获取模块的列表
    static  function getModuleList(){
        return ArrayHelper::map(Module::find()->select(['id', 'name'])->asArray()->all(), 'id', 'name');
    }
}