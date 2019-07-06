<?php
namespace backend\modules\gameuser\controllers;

use backend\libraries\base\Controller;
use backend\modules\gameuser\service\RoleService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class NewaddController extends Controller
{


   //新增角色
    public function actionRegRole()
    {
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $regRoleArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach($res as $v){
                $time = strtotime($v);
                $regRoleArr[$v] = RoleService::getInstance()->countRegRoleNum($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('reg-role-ajax',['regRoleArr'=>$regRoleArr]);
        } else {
            return $this->render('reg-role');
        }

    }
    /*
     * 新增设备
     * **/
    //活跃角色
    public function actionRegDevice()
    {
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $RegDeviceArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $RegDeviceArr[$v] = RoleService::getInstance()->countDeviceNum($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('reg-device-ajax',['regDeviceArr'=>$RegDeviceArr]);
        } else {
            return $this->render('reg-device');
        }
    }

}
