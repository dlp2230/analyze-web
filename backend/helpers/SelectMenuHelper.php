<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 14:27
 */

namespace backend\helpers;

use common\models\AdminGame;
use common\models\Channel;
use common\models\Game;
use common\models\Server;
use common\models\ServerChannel;
use Yii;
use common\libraries\base\Object;
use yii\helpers\ArrayHelper;

class SelectMenuHelper extends Object
{
    public function createGscSelectMenu($uid)
    {
//        Yii::$app->session->set('game_id',51);
//        Yii::$app->session->set('server_type',3);
//        Yii::$app->session->set('server','S002');

        //初始化服务器类型
        $server_types = Server::$server_type;
        Yii::$app->view->_selectMenu['server_types'] = $server_types;
        //处理并解析出展示的game_id
        $game_ids = ArrayHelper::getColumn(AdminGame::findAll(['id' => $uid]), 'game_id');
        if (!$games = ArrayHelper::map(Game::findAll(['game_id' => $game_ids]), 'game_id', 'name')) {
            return;
        }
        Yii::$app->view->_selectMenu['games'] = $games;
        if (!$game_id = Yii::$app->session->get('game_id')) {
            return;
        }
        Yii::$app->view->_selectMenu['_game'] = $game_id;
        //处理并解析出展示的区服类型
        if (!$server_type = Yii::$app->session->get('server_type')) {
            return;
        }
        Yii::$app->view->_selectMenu['_server_type'] = $server_type;

        //处理并解析出展示的区服
        if (!$servers = ArrayHelper::map(Server::findAll(['game_id' => $game_id, 'server_type' => $server_type]), 'sid', 'name')) {
            return;
        }
        Yii::$app->view->_selectMenu['servers'] = $servers;
        if (!$server = Yii::$app->session->get('server')) {
            return;
        }
        Yii::$app->view->_selectMenu['_server'] = $server;

        //可见平台
        $channel_ids = ArrayHelper::getColumn(ServerChannel::findAll(['sid' => $server]), 'channel_id');
        if (!$channels = ArrayHelper::map(Channel::findAll(['channel_id' => $channel_ids]), 'channel_id', 'name')) {
            return;
        }
        Yii::$app->view->_selectMenu['channels'] = $channels;
        if (!$channel = Yii::$app->session->get('channel')) {
            return;
        }
        Yii::$app->view->_selectMenu['_channel'] = $channel;
    }

    public function createGcSelectMenu($uid)
    {
//        Yii::$app->session->set('game_id',51);
//        Yii::$app->session->set('server_type',3);
//        Yii::$app->session->set('server','S002');

        //处理并解析出展示的game_id
        $game_ids = ArrayHelper::getColumn(AdminGame::findAll(['id' => $uid]), 'game_id');
        Yii::$app->view->_selectMenu['games'] = ArrayHelper::map(Game::findAll(['game_id' => $game_ids]), 'game_id', 'name');

        if ($game_id = Yii::$app->session->get('game_id')) {
            Yii::$app->view->_selectMenu['_game'] = $game_id;
        }
        //可见平台
        if (!$channels = ArrayHelper::map(Channel::find()->all(), 'channel_id', 'name')) {
            return;
        }
        Yii::$app->view->_selectMenu['channels'] = $channels;
        if (!$channel = Yii::$app->session->get('channel')) {
            return;
        }
        Yii::$app->view->_selectMenu['_channel'] = $channel;
    }
}