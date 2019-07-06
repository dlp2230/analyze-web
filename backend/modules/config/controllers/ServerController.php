<?php
namespace backend\modules\config\controllers;


use backend\modules\config\services\ChannelService;
use backend\modules\config\services\GameService;
use backend\modules\config\services\ServerService;
use backend\modules\config\services\ClearService;
use common\models\Channel;
use common\models\Server;
use Yii;
use backend\libraries\base\Controller;
use yii\helpers\ArrayHelper;


/**
 * Perm controller
 */
class ServerController extends Controller
{
    public function actionList()
    {
        $params =[
            'game_id = ' => Yii::$app->request->get('game_id'),
            'server_type = ' => Yii::$app->request->get('server_type'),
        ];

        $list = $this->quickDataAndPage('backend\modules\config\services\ServerService',
            'getList', ['disNums' => 20],$params);
        $device_type = Channel::$device_type;
        $server_type = Server::$server_type;
        $game_list = GameService::getInstance()->getGameList();
        //自动填写表单
        $this->quickFillForm();
        return $this->render('list', ['list' => $list,'device_type'=>$device_type,'server_type'=>$server_type,'game_list'=>$game_list,'params'=>$params]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $game_list = GameService::getInstance()->getGameList();
            $channel_list = ChannelService::getInstance()->getChannelList();
            $server_type_list = Server::$server_type;
            return $this->renderAjax('addOrUpd.php', ['game_list' => $game_list, 'channel_list' => $channel_list, 'server_type_list' => $server_type_list]);
        } else {
            $server = new Server();
            $server->sid = Yii::$app->request->post('sid');
            $server->game_id = Yii::$app->request->post('game_id');
            $server->name = Yii::$app->request->post('name');
            $server->open_server_time = Yii::$app->request->post('open_server_time');
            $channel_ids = Yii::$app->request->post('channel_ids');
            ServerService::getInstance()->addServerChannel($server->sid, $channel_ids);
            $server_type = ServerService::getInstance()->getServerType($channel_ids);
            if ($server_type !== false) {
                $server->server_type = $server_type;
            } else {
                return $this->renderJson(['ok' => 0, 'msg' => '渠道选择错误!']);
            }
            $server->save();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionCheckChannelType()
    {
        $server_type = '';
        if (Yii::$app->request->isGet) {
            $channel_ids = Yii::$app->request->get('channel_ids');
            if ($channel_ids != '') {
                $server_type = ServerService::getInstance()->getServerType($channel_ids);

                if ($server_type === false) {
                    return $this->renderJson(['ok' => 0, 'msg' => '渠道选择错误!']);
                }
            }
        }
        return $this->renderJson(['ok' => 1, 'server_type' => $server_type, 'msg' => '渠道选择正确!']);
    }

    public function actionDel()
    {
        $sid = Yii::$app->request->get('sid');
        Server::deleteAll(['sid' => $sid]);
        //删除server_channel表中的相关内容
        ServerService::getInstance()->delSeverChannel($sid);
        return $this->renderJson(['ok' => 1,'code'=>1, 'msg' => '删除成功!']);
    }
    /*
     * 清档
     * **/
    public function actionClearfile()
    {
        $sid  = Yii::$app->request->get('sid');
        $game_id = Yii::$app->request->get('game_id');
        $open_server_time = Yii::$app->request->get('openservertime');
        $res = ClearService::getInstance()->clearFile($game_id,$sid,$open_server_time);
        if($res){
            return $this->renderJson(['ok' => 1,'receipt'=>1, 'msg' => '清档成功!']);
        }else{
            return $this->renderJson(['ok' => 1,'receipt'=>1, 'msg' => '清档失败!']);
        }
    }


    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {
            $sid = Yii::$app->request->get('sid');
            $type = 'edit';
            $item = Server::findOne(['sid' => $sid]);
            $server_channel_list = ServerService::getInstance()->getServerChannelList($sid);
            $game_list = GameService::getInstance()->getGameList();
            $channel_list = ChannelService::getInstance()->getChannelList();
            $server_type_list = Server::$server_type;
            return $this->renderPartial('addOrUpd', ['type' => $type, 'item' => $item, 'server_channel_list' => $server_channel_list, 'game_list' => $game_list, 'channel_list' => $channel_list, 'server_type_list' => $server_type_list]);
        } else {
            $condtion['sid'] = Yii::$app->request->post('oid');
            $param['sid'] = Yii::$app->request->post('sid');
            $param['game_id'] = Yii::$app->request->post('game_id');
            $param['name'] = Yii::$app->request->post('name');
            $param['open_server_time'] = Yii::$app->request->post('open_server_time');
            $channel_ids = Yii::$app->request->post('channel_ids');
            ServerService::getInstance()->addServerChannel($param['sid'], $channel_ids);
            $server_type = ServerService::getInstance()->getServerType($channel_ids);
            if ($server_type !== false) {
                $param['server_type'] = $server_type;
            } else {
                return $this->renderJson(['ok' => 0, 'msg' => '渠道选择错误!']);
            }
            Server::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }

    public function actionBatchupd(){
        if(Yii::$app->request->isGet){
            $sid=Yii::$app->request->get('sid');
            $channel_list = ChannelService::getInstance()->getChannelList();
            $server_type_list = Server::$server_type;
            return $this->renderPartial('batchupd',['sid'=>$sid,'channel_list'=>$channel_list,'server_type_list'=>$server_type_list]);
        }else{
            $server_ids=Yii::$app->request->post('server_ids');
            $server_id=array_filter(explode(',',$server_ids));
            $channel_ids=Yii::$app->request->post('channel_ids');
            ServerService::getInstance()->batchupd($server_id,$channel_ids);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }


}
