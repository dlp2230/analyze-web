<?php
namespace backend\modules\gameuser\controllers;

use backend\libraries\base\Controller;
use backend\modules\gameuser\service\RetentionService;
use backend\modules\gameuser\service\RoleService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class RetentionController extends Controller
{

    //留存
    public function actionRetention()
    {
        $retentionDay = Yii::$app->params['retentionDay'];
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $retrntion_arr = [];

            $res = Tool::getDateLists($start_time,$end_time);
            foreach($res as $v){
                $time = strtotime($v);
                $retrntion_arr[$v]['total'] = RoleService::getInstance()->countRegRoleNum($game_id,$server_id,$channel_id,$time);
                foreach ($retentionDay as $day) {
                    $retrntion_arr[$v][$day] = RetentionService::getInstance()->countRetention($game_id, $server_id, $channel_id, $time, $day);
                }
            }
            //检查留存率该留存率是否完整
            return $this->renderAjax('retention-ajax', ['retrntion_arr' => $retrntion_arr, 'retentionDay' => $retentionDay]);
        } else {
            return $this->render('retention', ['retentionDay' => $retentionDay]);
        }
    }
    /*
     *设备留存
     * */
    public function actionDevice()
    {
        $retentionDay = Yii::$app->params['retentionDay'];
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $retrntion_arr = [];

            /*
             *添加设备数
             * ***/
            $res = Tool::getDateLists($start_time,$end_time);
            foreach($res as $v){
                $time = strtotime($v);
                $retrntion_arr[$v]['total'] = RoleService::getInstance()->countDeviceNum($game_id,$server_id,$channel_id,$time);
                foreach ($retentionDay as $day) {
                    $retrntion_arr[$v][$day] = RetentionService::getInstance()->countRetentionDevice($game_id, $server_id, $channel_id, $time, $day);
                }
            }

            //检查留存率该留存率是否完整
            return $this->renderAjax('device-ajax', ['retrntion_arr' => $retrntion_arr, 'retentionDay' => $retentionDay]);
        } else {
            return $this->render('device', ['retentionDay' => $retentionDay]);
        }
    }

  }
