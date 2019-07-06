<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\AdminGroup;
use common\models\AdminGroupPerm;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class AdminGroupService extends Service
{
    public function getList($start, $length, $where)
    {
        return AdminGroup::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return AdminGroup::find()->where($where)->count();
    }

    static function settingPerm($ag_id, $permData)
    {
        try {
            AdminGroupPerm::deleteAll(['ag_id' => $ag_id]);
            //Dao_Admin_AdminGroupPerm::getInstance()->getTable()->deleteWhere('ag_id', $ag_id)->execute();
            foreach ($permData as $perm) {
                $adminGroupPerm = new AdminGroupPerm();
                $adminGroupPerm->ag_id = $ag_id;
                $adminGroupPerm->perm_id = $perm;
                $adminGroupPerm->insert();
                //Dao_Admin_AdminGroupPerm::getInstance()->insert(['ag_id' => $ag_id, 'perm_id' => $perm]);
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public static function getAdminGroupKV()
    {
        return ArrayHelper::map(AdminGroup::find()->select(['ag_id', 'name'])->asArray()->all(), 'ag_id', 'name');
    }
}