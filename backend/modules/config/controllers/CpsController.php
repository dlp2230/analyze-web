<?php
namespace backend\modules\config\controllers;


//use backend\modules\config\services\CpsService;
use backend\modules\config\services\ChannelService;
use Yii;
use backend\libraries\base\Controller;
use common\models\Cps;

/**
 * Perm controller
 */
class CpsController extends Controller
{
    public function actionList()
    {
        $list = $this->quickDataAndPage('backend\modules\config\services\CpsService',
            'getList', ['disNums' => 20]);
        $channel_list = ChannelService::getInstance()->getChannelList();
        return $this->render('list', ['list' => $list,'channel_list'=>$channel_list]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {

            $channel_list = ChannelService::getInstance()->getChannelList();

            return $this->renderPartial('addOrUpd.php',['channel_list'=>$channel_list]);
        } else {
            $cps = new Cps();
            $cps['cps_id'] = Yii::$app->request->post('cps_id');
            $cps['channel_id'] = Yii::$app->request->post('channel_id');
            $cps['name'] = Yii::$app->request->post('name');
            $cps ->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $cps_id = Yii::$app->request->get('cps_id');
        Cps::deleteAll(['cps_id'=>$cps_id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {

            $cps_id = Yii::$app->request->get('cps_id');
            $type = 'edit';
            $item = Cps::findOne(['cps_id'=>$cps_id]);
            $channel_list = ChannelService::getInstance()->getChannelList();
            return $this->renderPartial('addOrUpd',['type'=>$type,'item'=>$item,'channel_list'=>$channel_list]);

        } else {

            $condtion['cps_id'] = Yii::$app->request->post('oid');
            $param['cps_id'] = Yii::$app->request->post('cps_id');
            $param['channel_id'] = Yii::$app->request->post('channel_id');
            $param['name'] = Yii::$app->request->post('name');
            Cps::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }




}
