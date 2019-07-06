<?php
namespace backend\modules\consumption\controllers;

use backend\libraries\base\Controller;
use backend\modules\consumption\service\ConsumeService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class ConsumptionController extends Controller
{

     public function actionRegGive(){

        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = strtotime(Yii::$app->request->get('start_time'));
            if ($start_time == '') {
                $start_time = time();
            }
            $end_time = strtotime(Yii::$app->request->get('end_time'));
            if ($end_time == '') {
                $end_time = $start_time;
            }

            $LossArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $LossArr[$v] = ConsumeService::getInstance()->CountRegGive($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('reggive-ajax',['LossArr'=>$LossArr]);
        } else {
           return $this->render('reggive');
        }
    }
    /*
     * RMB
     * **/
    public function actionRegMoney(){
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));

            $LossArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $LossArr[$v] = ConsumeService::getInstance()->CountRegGive($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('regmoney-ajax',['LossArr'=>$LossArr]);
        } else {
            return $this->render('regmoney');
        }
    }
    /*
     * give
     * **/
    public function actionGive(){
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $LossArr = [];

            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $LossArr[$v] = ConsumeService::getInstance()->CountRegGive($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('give-ajax',['LossArr'=>$LossArr]);
        } else {
            return $this->render('give');
        }
    }

}
