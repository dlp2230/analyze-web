<?php
namespace backend\modules\pay\controllers;

use backend\libraries\base\Controller;
use backend\modules\pay\service\PayService;
use backend\helpers\Tool;
use common\models\Channel;
use Yii;

/**
 * Perm controller
 */
class PayGroupController extends Controller
{
    /*
     * 付费排行榜
     * ***/
    public function actionRankList(){
        $ranks = Yii::$app->params['incomeTop'];
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $ranking = !empty(Yii::$app->request->get('ranking')) ? intval(Yii::$app->request->get('ranking')) : 100;
            $resultArr = PayService::getInstance()->CountRankList($game_id,$server_id,$channel_id,$start_time,$end_time,$ranking);
            $channelArr = Channel::getChannelName();
           return $this->renderAjax('ranklist-ajax',['resultArr'=>$resultArr,'ranks'=>$ranks,'channelArr'=>$channelArr]);
        } else {
           return $this->render('ranklist',['ranks'=>$ranks]);
        }
    }
    /*
     * 付费额度分布
     * **/
   public function actionQuota(){
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
                $resultArr[$v] = PayService::getInstance()->getQuotaDist($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('quota-ajax',['resultArr'=>$resultArr]);
        } else {
            return $this->render('quota');
        }
    }


}
