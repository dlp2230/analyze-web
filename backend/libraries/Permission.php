<?php
namespace backend\libraries;

use common\models\Admin;
use common\models\AdminGroupPerm;
use common\models\Menu;
use common\models\Module;
use common\models\Perm;
use common\models\PermGroup;
use common\libraries\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/3
 * Time: 10:17
 */
class Permission extends Object
{
    public $userid;
    public $userinfo;
    public $username;
    public $userGroup;
    public $needPerm;
    public $menu = [];
    public $activeMenu = [];

    /**
     * 权限的初始化
     */
    public function init($userid)
    {
        $this->userid = $userid;
        $this->userinfo = Admin::findOne($userid);
        //获取用户组权限
        $this->userGroup = $this->userinfo['ag_id'];
    }

    /**
     * 判断当前页面是否可以访问
     * $mca = '/xx/xx/xx'
     */
    public function checkPerm($route)
    {
        //获取当前mca对应权限表示
        if ($route['c'] != 'index') {
            if ($route['a'] != 'index') {
                $mcaTree = strtolower($route['m'] . '_' . $route['c'] . '_' . $route['a']);
                $this->needPerm = $this->getAllNeedPerm($mcaTree);//ee($this->needPerm);
            } else {
                $mcaTree = strtolower($route['m'] . '_' . $route['c']);
                $this->needPerm = $this->getAllNeedPerm($mcaTree, false);
            }
        } else {
            $mcaTree = strtolower($route['m']);
            $module = Module::findOne($mcaTree);
            $this->needPerm[] = $module->perm_id;
        }

        if (empty($this->needPerm)) {
            return true;
        }

        $result = AdminGroupPerm::find()->andWhere(['in', 'perm_id', $this->needPerm])->andWhere(['ag_id' => $this->userinfo->ag_id])->all();
        if (count($this->needPerm) != count($result)) {
            return false;
        }
        return true;
    }

    protected function getAllNeedPerm($mca, $full = true)
    {
        $needPerm = [];
        if ($full) {
            $perm = Perm::findOne($mca);
            if (empty($perm)) {
                return $needPerm;
            }
            $needPerm[] = $perm->perm_id;
        } else {
            $mcaLen = strlen($mca);
            $perm = Perm::find()->Where(["left(id,$mcaLen)" => $mca])->one();

            if (empty($perm)) {
                return $needPerm;
            }
        }

        $permGroup = PermGroup::findOne($perm->pid);
        if (empty($permGroup)) {
            return $needPerm;
        }
        $needPerm[] = $permGroup->perm_id;
        $module = Module::findOne($permGroup->pid);
        if (empty($module)) {
            return $needPerm;
        }
        $needPerm[] = $module->perm_id;
        return $needPerm;
    }

    /**
     * 构建菜单
     */
    public function createMenu()
    {
        $data = AdminGroupPerm::findAll(['ag_id' => $this->userGroup]);
        $permArr = ArrayHelper::getColumn($data, 'perm_id');
        $menuArr = Menu::find()->orderBy('pid DESC,sort DESC')->indexBy('id')->all();
        foreach ($menuArr as $menu) {
            $menuPerms = explode(',', $menu->menu_perm_id);
            if (array_intersect($menuPerms, $permArr)) {
                $this->menu[$menu->pid][$menu->id] = $menu;
                //覆写父菜单的url
                if ($menu->pid != 0 && $menuArr[$menu->pid]->hasFix == false) {
                    $menuArr[$menu->pid]->route = $menu->route;
                    $menuArr[$menu->pid]->hasFix = true;
                }
            }
            if (array_intersect($menuPerms, $this->needPerm)) {
                $this->activeMenu[] = $menu->id;
            }
        }
        return ['menu' => $this->menu, 'activeMenu' => $this->activeMenu];
    }

}