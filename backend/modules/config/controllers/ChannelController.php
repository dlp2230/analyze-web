<?php
namespace backend\modules\config\controllers;


//use backend\modules\config\services\GameService;
use backend\modules\config\services\ChannelService;
use common\models\Channel;
use Yii;
use backend\libraries\base\Controller;

/**
 * Perm controller
 */
class ChannelController extends Controller
{
    public function actionList()
    {
        $where = [];
        $name = Yii::$app->request->get('name');
        if(!empty($name)){
            if(is_numeric($name)){
               $where = [
                   'channel_id = '=> $name,
               ];
            }else{
                $where =[
                    'name like ' =>'%'.$name.'%',
                ];
            }

        }
        $list = $this->quickDataAndPage('backend\modules\config\services\ChannelService',
            'getList', ['disNums' => 20],$where);
        $device_type = Channel::$device_type;
        return $this->render('list', ['list' => $list,'device_type'=>$device_type]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $device_type = Channel::$device_type;
            return $this->renderPartial('addOrUpd.php',['device_type'=>$device_type]);
        } else {
            $channel = new Channel();
            $channel->channel_id = Yii::$app->request->post('channel_id');
            $channel->name = Yii::$app->request->post('name');
            $channel->type = Yii::$app->request->post('type');
            $channel->insert();
            return $this->renderJson(['ok' => 1, 'receipt'=>1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $channel_id = Yii::$app->request->get('channel_id');
        Channel::deleteAll(['channel_id'=>$channel_id]);
        return $this->renderJson(['ok' => 1, 'receipt'=>1,'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {

            $channel_id = Yii::$app->request->get('channel_id');
            $type = 'edit';
            $item = Channel::findOne(['channel_id'=>$channel_id]);
            $device_type = Channel::$device_type;
            return $this->renderPartial('addOrUpd',['type'=>$type,'item'=>$item,'device_type'=>$device_type]);
        } else {
            $condtion['channel_id'] = Yii::$app->request->post('oid');
            $param['channel_id'] = Yii::$app->request->post('channel_id');
            $param['name'] = Yii::$app->request->post('name');
            $param['type'] = Yii::$app->request->post('type');
            Channel::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }




}
