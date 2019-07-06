<?php
namespace backend\modules\config\controllers;

use Yii;
use backend\libraries\base\Controller;
use common\models\Menu;

class MenuController extends Controller
{
    public function actionList()
    {

        $pid = Yii::$app->getRequest()->get('pid', 0);
        $level = Yii::$app->getRequest()->get('level', 1);
        if (!in_array($level, [1, 2, 3])) {
            $level = 1;
        }
        $list = $this->quickDataAndPage('backend\modules\config\services\MenuService',
            'getList', ['disNums' => 20], ['pid =' => $pid]);

        if ($level == 3) {
            $ppid = Menu::findOne(['id' => $pid])->toArray()['pid'];
            return $this->render('list' . $level, ['list' => $list, 'pid' => $pid, 'level' => $level, 'ppid' => $ppid]);
        } else {
            return $this->render('list' . $level, ['list' => $list, 'pid' => $pid, 'level' => $level]);
        }
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $pid = Yii::$app->getRequest()->get('pid', 0);
            $level = Yii::$app->getRequest()->get('level', 1);
            if (!in_array($level, [1, 2, 3])) {
                $level = 1;
            }
            return $this->renderPartial('addOrUpd' . $level, ['pid' => $pid, 'level' => $level]);
        } else {

            $menu = new Menu();
            $menu['pid'] = Yii::$app->getRequest()->post('pid');
            $menu['menu_name'] = Yii::$app->getRequest()->post('menu_name');
            $menu['is_menu'] = Yii::$app->getRequest()->post('is_menu');
            $menu['route'] = (!$menu['is_menu']) ? Yii::$app->getRequest()->post('route') : '';
            $menu['menu_perm_id'] = Yii::$app->getRequest()->post('menu_perm_id');
            $menu['icon'] = Yii::$app->getRequest()->post('icon');
            $menu['sort'] = Yii::$app->getRequest()->post('sort');
            $menu->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $id = Yii::$app->getRequest()->get('id');
        Menu::deleteAll(['id' => $id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {

        if (Yii::$app->request->isGet) {
            $level = Yii::$app->getRequest()->get('level', 1);
            if (!in_array($level, [1, 2, 3])) {
                $level = 1;
            }
            $id = Yii::$app->getRequest()->get('id');
            $type = 'edit';
            $item = Menu::findOne(['id' => $id]);
            return $this->renderPartial('addOrUpd' . $level, ['type' => $type, 'item' => $item, 'level' => $level]);
        } else {
            $condtion['id'] = Yii::$app->request->post('oid');
            $param['menu_name'] = Yii::$app->request->post('menu_name');
            $param['is_menu'] = Yii::$app->getRequest()->post('is_menu');
            $param['route'] = (!$param['is_menu']) ? Yii::$app->getRequest()->post('route') : '';
            $param['menu_perm_id'] = Yii::$app->request->post('menu_perm_id');
            $param['icon'] = Yii::$app->request->post('icon');
            $param['sort'] = Yii::$app->request->post('sort');
            Menu::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }
}