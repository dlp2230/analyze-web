<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Menu;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class MenuService extends Service
{
    public function getList($start, $length, $where)
    {
        return Menu::find()->where($where)->limit($length)->offset($start)->orderBy('sort desc')->all();
    }

    public function getListCount($where)
    {
        return Menu::find()->where($where)->count();
    }
}