<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\PermGroup;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class PermGroupService extends Service
{
    public function getList($start, $length, $where)
    {
        return PermGroup::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return PermGroup::find()->where($where)->count();
    }

    static function getPermGroupList(){
        $perm_group_list =  ArrayHelper::map(PermGroup::find()->select(['id', 'name','pid'])->asArray()->all(), 'id','name' ,'pid');
        $module_list = ModuleService::getInstance()->getModuleList();


        foreach($perm_group_list as $k1=>$v1){
            foreach($module_list as $k2=>$v2){
                if($k1 ==$k2){
                    $returnArr[$v2] = $v1;
                }
            }
        }
        return $returnArr;

    }
}