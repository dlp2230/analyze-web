<?php
namespace backend\modules\pay\controllers;

use backend\libraries\base\Controller;
use backend\modules\pay\service\PayService;
use backend\modules\gameuser\service\RoleService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class PenetrationController extends Controller
{

    /*
     * 付费
     * ***/
    public function actionRate(){
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
                $resultArr[$v] = PayService::getInstance()->CountRateTotal($game_id,$server_id,$channel_id,$time);
                $resultArr[$v]['reg_role'] = RoleService::getInstance()->countRegRoleNum($game_id,$server_id,$channel_id,$time);
            }
           return $this->renderAjax('rate-ajax',['resultArr'=>$resultArr]);
        } else {
           return $this->render('rate');
        }
    }
    /*
     * ARPU
     * ***/
    public function actionArpu(){
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
                $resultArr[$v] = PayService::getInstance()->countArpu($game_id,$server_id,$channel_id,$time);
                $resultArr[$v]['reg_role'] = RoleService::getInstance()->countRegRoleNum($game_id,$server_id,$channel_id,$time);
            }

           return $this->renderAjax('arpu-ajax',['resultArr'=>$resultArr]);
        } else {
            return $this->render('arpu');
        }
    }
    /*
 * ARPPU
 * ***/
    public function actionArppu(){
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
                if(($login_nums =RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$time)) == 0){
                    $resultArr[$v]['pay_nums'] = 0;
                    $resultArr[$v]['total'] = 0;
                    $resultArr[$v]['svg'] = 0.00;
                    $resultArr[$v]['reg_role'] = 0;
                }else{
                    $resultArr[$v] = PayService::getInstance()->countArppu($game_id,$server_id,$channel_id,$time);
                    $resultArr[$v]['reg_role'] = RoleService::getInstance()->countRegRoleNum($game_id,$server_id,$channel_id,$time);
                }
                $resultArr[$v]['login_nums'] = $login_nums;
            }

           return $this->renderAjax('arppu-ajax',['resultArr'=>$resultArr]);
        } else {
            return $this->render('arppu');
        }
    }


}
