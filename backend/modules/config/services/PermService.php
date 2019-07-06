<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Module;
use common\models\Perm;
use common\models\AdminGroup;
use common\models\AdminGroupPerm;
use common\models\PermGroup;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class PermService extends Service
{
    public function getList($start, $length, $where)
    {
        return Perm::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Perm::find()->where($where)->count();
    }

    static function createTree($ag_id)
    {
        //当前用户权限信息
        $user_perm = ArrayHelper::map(AdminGroupPerm::find()->select('perm_id')->where(['ag_id' => $ag_id])->asArray()->all(), 'perm_id', 'perm_id');
        $permList = Perm::find()->indexBy('id')->asArray()->all();
        $permGroupList = PermGroup::find()->indexBy('id')->asArray()->all();
        $moduleList = Module::find()->indexBy('id')->asArray()->all();
        $temp = [];
        foreach ($permList as $item) {
            $check = 'false';
            if (isset($user_perm[$item['perm_id']])) {
                $check = 'true';
            }
            $pid = $item['pid'];
            if (!isset($temp[$pid]['checked'])) {
                $temp[$pid]['checked'] = 'false';
            }
            if (isset($temp[$pid]['checked']) && $check == 'true') {
                $temp[$pid]['checked'] = 'true';
            }

            $temp[$pid]['children'][] = [
                'name' => $item['name'], 'value' => $item['perm_id'], 'checked' => $check
            ];
        }
        $tempPermGroupList = $temp;
        unset($temp);
        foreach ($permGroupList as $key => $item) {
            $pid = $item['pid'];
            $item_check = (isset($tempPermGroupList[$key])) ? $tempPermGroupList[$key]['checked'] : (isset($user_perm[$item['perm_id']]) ? 'true' : 'false');
            if (!isset($temp[$pid]['checked'])) {
                $temp[$pid]['checked'] = 'false';
            }
            if (isset($temp[$pid]['checked']) && ($item_check == 'true')) {
                $temp[$pid]['checked'] = 'true';
            }

            $temp[$pid]['children'][] = [
                'name' => $item['name'], 'value' => $item['perm_id'],

                'checked' => $item_check,
                'children' => (isset($tempPermGroupList[$key])) ? $tempPermGroupList[$key]['children'] : []
            ];
        }
        $tempModuleList = $temp;
        //pr($tempModuleList);
        unset($temp);
        foreach ($moduleList as $key => $item) {
            $temp[] = array(
                "name" => $item['name'],
                "value" => $item['perm_id'],
                "checked" => (isset($tempModuleList[$key])) ? $tempModuleList[$key]['checked'] : (isset($user_perm[$item['perm_id']]) ? 'true' : 'false'),

                "children" => (isset($tempModuleList[$key])) ? $tempModuleList[$key]['children'] : []
            );
        }
        return $temp;
    }
}