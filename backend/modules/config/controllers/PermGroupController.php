<?php
namespace backend\modules\config\controllers;

use
    backend\modules\config\services\ModuleService;
use Yii;
use backend\libraries\base\Controller;
use common\models\PermGroup;

/**
 * Perm controller
 */
class PermGroupController extends Controller
{
    public function actionList()
    {
        $list = $this->quickDataAndPage('backend\modules\config\services\PermGroupService',
            'getList', ['disNums' => 20]);
        return $this->render('list', ['list' => $list]);
    }


    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $module_list = ModuleService::getInstance()->getModuleList();
            return $this->renderPartial('addOrUpd.php',['module_list'=>$module_list]);
        } else {
            $permgGroup = new PermGroup();
            $permgGroup['id'] = Yii::$app->request->post('id');
            $permgGroup['perm_id'] = Yii::$app->request->post('perm_id');
            $permgGroup['name'] =Yii::$app->request->post('name');
            $permgGroup['pid'] =Yii::$app->request->post('pid');
            $permgGroup->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        PermGroup::deleteAll(['id'=>$id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if(Yii::$app->request->isGet){
            $id  = Yii::$app->request->get('id');
            $type =  'edit';
            $item = PermGroup::findOne(['id'=>$id]);
            $module_list = ModuleService::getInstance()->getModuleList();
            return $this->renderPartial('addOrUpd.php',['type'=>$type,'item'=>$item,'module_list'=>$module_list]);
        }
        else{
            $condtion['id'] = Yii::$app->request->post('oid');
            $param['id'] = Yii::$app->request->post('id');
            $param['perm_id'] = Yii::$app->request->post('perm_id');
            $param['name'] = Yii::$app->request->post('name');
            $param['pid'] = Yii::$app->request->post('pid');
            PermGroup::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }



}
