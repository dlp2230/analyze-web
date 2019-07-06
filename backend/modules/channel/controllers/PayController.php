<?php
namespace backend\modules\channel\controllers;

use backend\libraries\base\Controller;
use Yii;
use backend\modules\channel\service\ChannelService;

/**
 * Perm controller
 */
class PayController extends Controller
{

    /*
     * index
     * ***/
    public function actionMan(){
        if(Yii::$app->request->get()){
            $game_id=Yii::$app->session->get('game_id');
            $channel_id=Yii::$app->session->get('channel');
            $start_time=strtotime(Yii::$app->request->get('start_time'));
            $list = ChannelService::getInstance()->getPayMan($game_id,$channel_id,$start_time);
            return $this->renderAjax('man-ajax',['list'=>$list]);
        }else {
            return $this->render('man');
        }
    }

    public function actionSum(){
        if(Yii::$app->request->get()){
            $game_id=Yii::$app->session->get('game_id');
            $channel_id=Yii::$app->session->get('channel');
            $start_time=strtotime(Yii::$app->request->get('start_time'));
            $list = ChannelService::getInstance()->getPaySum($game_id,$channel_id,$start_time);
            return $this->renderAjax('sum-ajax',['list'=>$list]);
        }else {
            return $this->render('sum');
        }
    }

}