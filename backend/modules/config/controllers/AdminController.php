<?php
namespace backend\modules\config\controllers;

use backend\modules\config\services\AdminGameService;
use backend\modules\config\services\AdminGroupService;
use backend\modules\config\services\AdminService;
use backend\modules\config\services\GameService;
use common\models\AdminGame;
use Yii;
use backend\libraries\base\Controller;
use common\models\Admin;
use common\models\AdminGroup;
use yii\helpers\ArrayHelper;
use backend\helpers\Tool;

/**
 * Perm controller
 */
class AdminController extends Controller
{
    public function actionList()
    {
        $userGroup = ArrayHelper::map(AdminGroup::find()->select(['ag_id', 'name'])->asArray()->all(), 'ag_id', 'name');
        $list = $this->quickDataAndPage('backend\modules\config\services\AdminService',
            'getList', ['disNums' => 20]);
        return $this->render('list', ['list' => $list, 'userGroup' => $userGroup]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $userGroup = AdminGroupService::getAdminGroupKV();
            $games = GameService::getGameList();
            return $this->renderPartial('addOrUpd.php', ['userGroup' => $userGroup, 'games' => $games]);
        } else {
            $data['name'] = Yii::$app->getRequest()->post('name');
            $data['email'] = Yii::$app->getRequest()->post('email');
            $data['game_ids'] = Yii::$app->getRequest()->post('game_ids');
            $data['ag_id'] = Yii::$app->getRequest()->post('ag_id');
            $data['mobile'] = Yii::$app->getRequest()->post('mobile');
            $data['status'] = Yii::$app->getRequest()->post('status');
            $password = AdminService::getInstance()->add($data);
            return $this->renderJson(['ok' => 1, 'msg' => '初始密码为 ' . $password . ' 请记住!', 'code' => 1]);
        }
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        Admin::deleteAll(['id' => $id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {
            $id = Yii::$app->request->get('id');
            $type = 'edit';
            $item = Admin::findOne(['id' => $id]);
            $game_ids = AdminGameService::getInstance()->getAdminGame($id);
            $userGroup = AdminGroupService::getAdminGroupKV();
            $games = GameService::getGameList();
            return $this->renderPartial('addOrUpd',
                ['type' => $type, 'item' => $item, 'game_ids' => $game_ids, 'userGroup' => $userGroup, 'games' => $games]);
        } else {
            $condition['id'] = Yii::$app->request->post('oid');
            $param['name'] = Yii::$app->request->post('name');
            $param['email'] = Yii::$app->request->post('email');
            $param['ag_id'] = Yii::$app->request->post('ag_id');
            $param['mobile'] = Yii::$app->request->post('mobile');
            $param['status'] = Yii::$app->request->post('status');
            $param['game_ids'] = Yii::$app->request->post('game_ids');
            AdminService::getInstance()->upd($param, $condition);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }

    public function actionBatchupd(){
        if(Yii::$app->request->isGet){
            $item = ArrayHelper::map(Admin::find()->select(['id','name'])->asArray()->all(),'id','name');
            $games = GameService::getGameList();
            return $this->renderPartial('batchupd',['item'=>$item,'games'=>$games]);
        }else{
            $id=Yii::$app->request->post('id');
            $game_id=Yii::$app->request->post('game_ids');
            AdminService::getInstance()->batchupd($id,$game_id);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }

    public function actionReset()
    {
        if (Yii::$app->request->isGet) {
            $id = Yii::$app->request->get('id');
            $result = AdminService::resetPasswd(['id' => $id]);
            if ($result) {
                return $this->renderJson(['ok' => 1, 'msg' => '重置成功,新密码为 ' . $result . ' 请记住!', 'code' => 1]);
            } else {
                return $this->renderJson(['ok' => 0, 'msg' => '修改失败!']);
            }

        }
    }

    public function actionEditAdmin()
    {
        $error = '';
        if (Yii::$app->request->isPost) {
            $condtion['id'] = $userid = Yii::$app->session->get('userid');
            $old_password = Yii::$app->request->post('old_password');
            $param['password'] = Yii::$app->request->post('password');
            $result = Admin::findOne(['id' => $userid]);
            if (md5($old_password) != $result->password) {
                $error = '原密码不对';
            } else {
                if (empty($param['password'])) {
                    $error = '新密码居然为空?!!';
                } else {
                    $param['password'] = md5($param['password']);
                    if (Admin::updateAll($param, $condtion)) {
                        //Yii::$app->user->logout();
                        Tool::redirectJs("修改成功!请重新登陆", '/system/site/logout');
                    } else {
                        $error = '修改失败!';
                    }
                }
            }
        }
        return $this->render('editUser', ['error' => $error]);
    }
}
