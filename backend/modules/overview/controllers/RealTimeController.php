<?php
namespace backend\modules\overview\controllers;

use backend\libraries\base\Controller;
use backend\modules\overview\service\RealService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class RealTimeController extends Controller
{
    //实时在线
    public function actionOnline()
    {
       if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $resultArr= RealService::getInstance()->getRoleOnline($game_id,$server_id,$start_time,$end_time);
            return $this->renderAjax('online-ajax',['resultArr'=>$resultArr]);
        } else {
            return $this->render('online');
        }
    }

}
