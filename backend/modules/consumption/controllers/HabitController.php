<?php
namespace backend\modules\consumption\controllers;

use backend\libraries\base\Controller;
use backend\modules\consumption\service\ConsumeService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class HabitController extends Controller
{
    /*
     *消费排行榜
     * ***/
    public function actionChannel()
    {
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $res = Tool::getDateLists($start_time,$end_time);
            $resultArr = [];
            foreach ($res as $v) {
                $time = strtotime($v);
               // if(!empty(ConsumeService::getInstance()->getChannelDetail($game_id,$server_id,$channel_id,$time))){
                    $resultArr[$v] = ConsumeService::getInstance()->getChannelDetail($game_id,$server_id,$channel_id,$time);
                //}
            }
            $empty_num = 0;
            foreach($resultArr as $item){
                if(empty($item)){
                    $empty_num++;
                }
            }
            if(count($resultArr) > $empty_num){
                $is_display = 1;
            }else{
                $is_display = 0;
            }
            return $this->renderAjax('channel-ajax',['resultArr'=>$resultArr,'is_display'=>$is_display]);
        } else {
           return $this->render('channel');
        }
    }
    /*
     * 金币消费分析
     * ***/
    public function actionGold()
    {
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $res = Tool::getDateLists($start_time,$end_time);
            $resultArr = [];
            foreach ($res as $v) {
                $time = strtotime($v);
                $resultArr[$v] = ConsumeService::getInstance()->getGold($game_id,$server_id,$channel_id,$time);
            }
            $empty_num = 0;
            foreach($resultArr as $item){
                if(empty($item)){
                    $empty_num++;
                }
            }
            if(count($resultArr) > $empty_num){
              $is_display = 1;
            }else{
                $is_display = 0;
            }
            return $this->renderAjax('gold-ajax',['resultArr'=>$resultArr,'is_display'=>$is_display]);
        } else {
            return $this->render('gold');
        }
    }

}
