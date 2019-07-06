<?php
namespace backend\modules\channel\controllers;

use backend\libraries\base\Controller;
use Yii;
use backend\modules\channel\service\ChannelService;

/**
 * Perm controller
 */
class NewController extends Controller
{

    /*
     * index
     * ***/
    public function actionRole(){
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = strtotime(Yii::$app->request->get('start_time'));
            $list =ChannelService::getInstance()->countRole($game_id,$channel_id,$start_time);
            return $this->renderAjax('role-ajax',['list'=>$list]);
        } else {
            return $this->render('role');
        }

    }

    public function actionDevice(){
        if(Yii::$app->request->get()){
            $game_id=Yii::$app->session->get('game_id');
            $channel=Yii::$app->session->get('channel');
            $start_time=strtotime(Yii::$app->request->get('start_time'));
            $list=ChannelService::getInstance()->countDevice($game_id,$channel,$start_time);
            return $this->renderAjax('device-ajax',['list'=>$list]);
        }else {
            return $this->render('device');
        }
    }
}
