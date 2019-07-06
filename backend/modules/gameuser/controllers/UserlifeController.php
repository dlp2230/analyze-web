<?php
namespace backend\modules\gameuser\controllers;

use backend\libraries\base\Controller;
use backend\modules\pay\service\PayService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class UserlifeController extends Controller
{
    /*
     *新玩家价值
     * ***/
    public function actionPayContribution(){
        $payContributionArr = Yii::$app->params['payContribution'];
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
                $LossArr[$v] = PayService::getInstance()->CountComsumption($game_id,$server_id,$channel_id,$time,$loseday);
            }

            return $this->renderAjax('paycontribution-ajax',['loseDays'=>$payContributionArr,'LossArr'=>$LossArr]);
        } else {
            return $this->render('paycontribution',['loseDays'=>$payContributionArr]);
        }
    }


}
