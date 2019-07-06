<?php
namespace backend\modules\config\controllers;

use Yii;
use backend\libraries\base\Controller;
use common\models\Module;

/**
 * Perm controller
 */
class ModuleController extends Controller
{

    public function actionList()
    {
        $list = $this->quickDataAndPage('backend\modules\config\services\ModuleService',
            'getList', ['disNums' => 20]);
        //$this->_view->list = $this->quickDataAndPage('Service_Admin_Perm_Module', 'getList', ['disNums' => 20]);
        return $this->render('list', ['list' => $list]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            return $this->renderPartial('addOrUpd.php');
        } else {
            $module = new Module();
            $module['id'] =  Yii::$app->request->post('id');
            $module['perm_id'] =  Yii::$app->request->post('perm_id');
            $module['name'] = Yii::$app->request->post('name');
            $module->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        Module::deleteAll(['id'=>$id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {
            $id = Yii::$app->request->get('id');
            $type = 'edit';
            $item = Module::findOne(['id'=>$id]);
            return $this->renderPartial('addOrUpd.php',['type'=>$type,'item'=>$item]);
        } else {

            $condtion['id'] = Yii::$app->request->post('oid');
            $param['id'] = Yii::$app->request->post('id');
            $param['perm_id'] = Yii::$app->request->post('perm_id');
            $param['name'] = Yii::$app->request->post('name');
            Module::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }


}
