<?php
namespace backend\modules\pay\controllers;

use backend\libraries\base\Controller;
use backend\modules\pay\service\PayService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class PayController extends Controller
{
    /*
     * 流失玩家
     * ***/
    public function actionFirstCharge(){
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
                $resultArr[$v] = PayService::getInstance()->CountPayAdd($game_id,$server_id,$channel_id,$time);
            }

            return $this->renderAjax('firstcharge-ajax',['resultArr'=>$resultArr]);
        } else {
           return $this->render('firstcharge');
        }
    }


}
