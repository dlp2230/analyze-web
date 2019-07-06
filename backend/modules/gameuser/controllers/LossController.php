<?php
namespace backend\modules\gameuser\controllers;

use backend\libraries\base\Controller;
use backend\modules\gameuser\service\ActiveService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class LossController extends Controller
{
    /*
     * 流失玩家
     * ***/
    public function actionPlayerLoss(){
        $loseDays = Yii::$app->params['loseDay'];
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $loseday = Yii::$app->request->get('loseday');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $LossArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $LossArr[$v] = ActiveService::getInstance()->CountActiveLoss($game_id,$server_id,$channel_id,$time,$loseday);
            }
            return $this->renderAjax('playerloss-ajax',['loseDays'=>$loseDays,'LossArr'=>$LossArr]);
        } else {
           return $this->render('playerloss',['loseDays'=>$loseDays]);
        }
    }


}
