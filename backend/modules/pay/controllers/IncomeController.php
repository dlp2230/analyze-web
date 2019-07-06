<?php
namespace backend\modules\pay\controllers;

use backend\libraries\base\Controller;
use backend\modules\pay\service\PayService;
use backend\helpers\Tool;
use common\collections\log\PayLog;
use Yii;

/**
 * Perm controller
 */
class IncomeController extends Controller
{

    /*
     * 充值+赠送
     * ***/
    public function actionRechargeGive(){
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
                $LossArr[$v] = PayService::getInstance()->CountRecharge($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('rechargegive-ajax',['LossArr'=>$LossArr]);
        } else {
           return $this->render('rechargegive');
        }
    }
    /*
     * 人民币充值
     * ***/
    public function actionRegRmb(){
        $payTypeConfig = PayLog::$payTypeConfig;
        if(Yii::$app->request->get()){
             $game_id = Yii::$app->session->get('game_id');
             $server_id = Yii::$app->session->get('server');
             $channel_id = Yii::$app->session->get('channel');
             $role_id = Yii::$app->request->get('role_id');
             $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
             $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
             if(empty($game_id) || empty($server_id) || empty($start_time)){
                 Tool::redirectJs("条件不能为空!", '/pay/income/reg-rmb');
             }
             $params =[
                'game_id'=>$game_id,
                'server_id'=>$server_id,
                'channel_id'=>$channel_id,
                'role_id'=>$role_id,
                'start_time'=>$start_time,
                'end_time'=>$end_time,
             ];

             $resultArr = $this->quickMongoDataAndPage('backend\modules\pay\service\PayService',
                 'getRegRmbDetail', ['disNums' => 20],$params);
             return $this->render('regrmb',['resultArr'=>$resultArr,'payTypeConfig'=>$payTypeConfig]);
         }else{
             $resultArr = [];
             return $this->render('regrmb',['resultArr'=>$resultArr,'payTypeConfig'=>$payTypeConfig]);
         }


    }
    /*
     * GM 发送货币
     * ***/
    public function actionRegAdd(){
            $resultArr = $this->quickDataAndPage('backend\modules\pay\service\PayService',
                                                     'getList', ['disNums' => 20]);
            return $this->render('regadd',['resultArr'=>$resultArr]);

    }

}
