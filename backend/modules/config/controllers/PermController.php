<?php
namespace backend\modules\config\controllers;

use backend\modules\config\services\ModuleService;
use backend\modules\config\services\PermGroupService;
use Yii;
use backend\libraries\base\Controller;
use common\models\Perm;

/**
 * Perm controller
 */
class PermController extends Controller
{
    public function actionList()
    {
        $where = [];
        $name = Yii::$app->request->get('name');
        if(!empty($name)){
            $where =[
                'name like ' =>'%'.$name.'%',
            ];
        }
         $list = $this->quickDataAndPage('backend\modules\config\services\PermService',
            'getList', ['disNums' => 20],$where);
        return $this->render('list', ['list' => $list]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $perm_group_list = PermGroupService::getInstance()->getPermGroupList();
            return $this->renderPartial('addOrUpd.php',['perm_group_list'=>$perm_group_list]);
        } else {

            $perm = new Perm();
            $perm['id'] = Yii::$app->request->post('id');
            $perm['perm_id'] = Yii::$app->request->post('perm_id');
            $perm['name'] = Yii::$app->request->post('name');
            $perm['pid'] = Yii::$app->request->post('pid');
            $perm->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        Perm::deleteAll(['id'=>$id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if(Yii::$app->request->isGet){
            $id  = Yii::$app->request->get('id');
            $type =  'edit';
            $item = Perm::findOne(['id'=>$id]);
            $perm_group_list = PermGroupService::getInstance()->getPermGroupList();
            return $this->renderPartial('addOrUpd.php',['type'=>$type,'item'=>$item,'perm_group_list'=>$perm_group_list]);
        }
        else{
          $condtion['id'] = Yii::$app->request->post('oid');
            $param['id'] = Yii::$app->request->post('id');
            $param['perm_id'] = Yii::$app->request->post('perm_id');
            $param['name'] = Yii::$app->request->post('name');
            $param['pid'] = Yii::$app->request->post('pid');
            Perm::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }


    }
}
