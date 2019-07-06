<?php
namespace backend\modules\consumption\controllers;

use backend\libraries\base\Controller;
use backend\modules\consumption\service\ConsumeService;
use common\models\Channel;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class ConsumerGroupController extends Controller
{
    /*
     *消费排行榜
     * ***/
    public function actionTop(){
        $ranks = Yii::$app->params['ranks'];
        if (Yii::$app->request->get()) {
           $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $ranking = !empty(Yii::$app->request->get('ranking')) ? intval(Yii::$app->request->get('ranking')) : 100;
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $resultArr = [];
            $resultArr = ConsumeService::getInstance()->getConsumptionTop($game_id,$server_id,$channel_id,$start_time,$end_time,$ranking);
            $channelArr = Channel::getChannelName();
           return $this->renderAjax('top-ajax',['ranks'=>$ranks,'resultArr'=>$resultArr,'channelArr'=>$channelArr]);
        } else {
           return $this->render('top',['ranks'=>$ranks]);
        }
    }

}
