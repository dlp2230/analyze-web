<?php
namespace backend\modules\config\controllers;

use backend\modules\config\services\AdminGroupService;
use backend\modules\config\services\PermService;
use Yii;
use backend\libraries\base\Controller;
use common\models\AdminGroup;

/**
 * Perm controller
 */
class AdminGroupController extends Controller
{
    public function actionList()
    {
        $list = $this->quickDataAndPage('backend\modules\config\services\AdminGroupService',
            'getList', ['disNums' => 20]);
        return $this->render('list', ['list' => $list]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            return $this->renderPartial('addOrUpd.php');
        } else {
            $adminGroup = new AdminGroup();
            $adminGroup['name'] = Yii::$app->request->post('name');
            $adminGroup['description'] = Yii::$app->request->post('description');
            $adminGroup['type'] =Yii::$app->request->post('type');
            $adminGroup ->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        AdminGroup::deleteAll(['ag_id'=>$id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {

            $ag_id = Yii::$app->request->get('id');
            $type = 'edit';
            $item = AdminGroup::findOne(['ag_id'=>$ag_id]);
            return $this->renderPartial('addOrUpd',['type'=>$type,'item'=>$item,'ag_id'=>$ag_id]);

        } else {

            $condtion['ag_id'] = Yii::$app->request->post('oid');
            $param['name'] = Yii::$app->request->post('name');
            $param['description'] = Yii::$app->request->post('description');
            AdminGroup::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }

    public function actionSetting()
    {
        if (Yii::$app->request->isGet) {
            $ag_id = Yii::$app->request->get('id');
            $data = PermService::createTree($ag_id);
            $agInfo = AdminGroup::findOne(['ag_id'=>$ag_id]);



            $data = json_encode($data);



            return $this->renderPartial('setting', ['agInfo' => $agInfo,'data'=>$data]);

            //$this->_view->singleDisplay('userGroup/setting');
        } else {
            $ag_id = Yii::$app->request->post('ag_id');
            $permData = json_decode(Yii::$app->request->post('perm'), true);
            if (AdminGroupService::settingPerm($ag_id, $permData)) {
                return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
            } else {
                return $this->renderJson(['ok' => 0, 'msg' => '修改失败!']);
            }
        }

    }


}
