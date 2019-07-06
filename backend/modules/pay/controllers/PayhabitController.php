<?php
namespace backend\modules\pay\controllers;

use backend\libraries\base\Controller;
use backend\modules\pay\service\PayService;
use common\models\Channel;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class PayhabitController extends Controller
{
    /*
     * 付费
     * ***/
    public function actionPayFrequency(){
      if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $resultArr = PayService::getInstance()->CountFrequency($game_id,$server_id,$channel_id,$start_time,$end_time);
            $newArr=[];
            if(!empty($resultArr)){
                foreach($resultArr as $item){
                    if(isset($item['num'])){
                        $newArr[$item['num']]['num'] = $item['num'];
                        $newArr[$item['num']]['total'] = count($resultArr);
                        $newArr[$item['num']]['reg_num'][] = $item['_id'];
                    }

                }
            }
           ksort($newArr);
           return $this->renderAjax('payfrequency-ajax',['resultArr'=>$newArr]);
        } else {
           return $this->render('payfrequency');
        }
    }
    /*
     * 渠道付费情况
     * **/
    public function actionPayChannel(){
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));

            $resultArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $resultArr[$v] = PayService::getInstance()->CountPayChannel($game_id,$server_id,$channel_id,$time);
            }
            $channelArr = Channel::getChannelName();
            return $this->renderAjax('paychannel-ajax',['resultArr'=>$resultArr,'channelArr'=>$channelArr]);
        } else {
            return $this->render('paychannel');
        }
    }


}
