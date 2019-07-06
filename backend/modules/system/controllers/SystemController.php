<?php
/**
 * Created by PhpStorm.
 * User: xg
 * Date: 2015/11/27
 * Time: 16:25
 */
namespace backend\modules\system\controllers;


use backend\libraries\base\Controller;
use common\models\Channel;
use common\models\Server;
use common\models\ServerChannel;
use Yii;
use yii\helpers\ArrayHelper;

class SystemController extends Controller
{
    public function actionSelectGameId()
    {
        Yii::$app->session->set('game_id', Yii::$app->request->get('game_id'));
        Yii::$app->session->set('server_type', '');
        Yii::$app->session->set('server', '');
        Yii::$app->session->set('channel', '');
        return $this->renderJson(['ok' => 1]);
    }

    public function actionSelectServerType()
    {
        $game_id = Yii::$app->session->get('game_id');
        $server_type = Yii::$app->request->get('server_type');
        Yii::$app->session->set('server_type', $server_type);
        Yii::$app->session->set('server', '');
        Yii::$app->session->set('channel', '');
        $servers = ArrayHelper::map(Server::findAll(['game_id' => $game_id, 'server_type' => $server_type]), 'sid', 'name');
        return $this->renderJson(['ok' => 1, 'data' => $servers]);
    }

    public function actionSelectServer()
    {
        $server = Yii::$app->request->get('server');
        Yii::$app->session->set('server', $server);
        $channel_ids = ArrayHelper::getColumn(ServerChannel::findAll(['sid' => $server]), 'channel_id');
        $channels = ArrayHelper::map(Channel::findAll(['channel_id' => $channel_ids]), 'channel_id', 'name');
        return $this->renderJson(['ok' => 1, 'data' => $channels]);
    }

    public function actionSelectChannel()
    {
        Yii::$app->session->set('channel', Yii::$app->request->get('channel'));
        return $this->renderJson(['ok' => 1]);
    }

    //记录左侧的信息到数据库
    public function actionGscSetLeftSelect(){
        Yii::$app->session->set('game_id', Yii::$app->request->get('game_id'));
        Yii::$app->session->set('server_type', Yii::$app->request->get('server_type'));
        Yii::$app->session->set('server', Yii::$app->request->get('server'));
        Yii::$app->session->set('channel', Yii::$app->request->get('channel'));
        return $this->renderJson(['ok' => 1]);
    }

    public function actionGcSetLeftSelect(){
        Yii::$app->session->set('game_id', Yii::$app->request->get('game_id'));
        Yii::$app->session->set('channel', Yii::$app->request->get('channel'));
        return $this->renderJson(['ok' => 1]);
    }
}