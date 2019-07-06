<?php
namespace backend\modules\config\controllers;


use backend\modules\config\services\PhatformService;
use common\models\Phatform;
use backend\config\CacheKey;
use Yii;
use backend\libraries\base\Controller;


class SecretkeyController extends Controller{

    public function actionList()
    {
        //Yii::$app->redis->executeCommand('hdel', [CacheKey::H_PhatformKey_PhatformInfo,$game_id]);

        $list = $list = $this->quickDataAndPage('backend\modules\config\services\PhatformService',
            'getList', ['disNums' => 20]);
        return $this->render('list',['list' => $list]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            return $this->renderPartial('addOrUpd.php');
        } else {
            $game = new Phatform();
            $game['game_id'] = Yii::$app->request->post('game_id');
            $game['name'] = Yii::$app->request->post('name');
            $game['status'] =Yii::$app->request->post('status');
            $game['private_key'] = md5(Yii::$app->request->post('private_key'));
            $game->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionUpd(){
        if (Yii::$app->request->isGet) {
            $game_id = Yii::$app->request->get('game_id');
            $item = Phatform::findOne(['game_id' => $game_id]);
            $type = 'edit';
            return $this->renderPartial('addOrUpd.php', ['item' => $item,'type'=> $type]);

        } else {
            $condtion['game_id'] = Yii::$app->request->post('oid');
            $param['name'] = Yii::$app->request->post('name');
            $param['game_id'] = Yii::$app->request->post('game_id');
            $param['private_key'] =Yii::$app->request->post('private_key');
            $param['status'] = Yii::$app->request->post('status');
            Yii::$app->redis->executeCommand('hdel', [CacheKey::H_PhatformKey_PhatformInfo,$param['game_id']]);
            Phatform::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }

    public function actionStatus(){
        $game_id['game_id'] = Yii::$app->request->get('game_id');
        $item=Phatform::findOne($game_id);
        Yii::$app->redis->executeCommand('hdel', [CacheKey::H_PhatformKey_PhatformInfo,$game_id]);
        if($item->status == 1){
            $item->status =0;
        }else{
            $item->status =1;
        }
        $item->update();
        return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
    }
}