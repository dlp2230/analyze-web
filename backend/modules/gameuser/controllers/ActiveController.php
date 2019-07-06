<?php
namespace backend\modules\gameuser\controllers;

use backend\libraries\base\Controller;
use backend\modules\gameuser\service\RoleService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class ActiveController extends Controller
{
    //活跃角色
    public function actionActiveRole()
    {
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $activeRoleArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach($res as $v){
                $time = strtotime($v);
                $activeRoleArr[$v] = RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$time);
            }
            return $this->renderAjax('active-role-ajax',['activeRoleArr'=>$activeRoleArr]);
        } else {
            return $this->render('active-role');
        }
    }
    /*
     * new user 占比  新增角色数/活跃用户数
    **/
    public function actionProportion()
    {
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->session->get('game_id');
            $server_id = Yii::$app->session->get('server');
            $channel_id = Yii::$app->session->get('channel');
            $start_time = Tool::filterTime(strtotime(Yii::$app->request->get('start_time')));
            $end_time = Tool::filterTime(strtotime(Yii::$app->request->get('end_time')));
            $ProportionArr = [];
            $res = Tool::getDateLists($start_time,$end_time);
            foreach ($res as $v) {
                $time = strtotime($v);
                $ProportionArr[$v]['reg_role'] = RoleService::getInstance()->countRegRoleNum($game_id,$server_id,$channel_id,$time);
                $ProportionArr[$v]['active'] = RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$time);
                if($ProportionArr[$v]['active'] == 0){
                    $ProportionArr[$v]['svg'] = '0.00';
                }else{
                    $ProportionArr[$v]['svg'] = sprintf("%.2f",$ProportionArr[$v]['reg_role']/$ProportionArr[$v]['active']*100);
                }
            }

            return $this->renderAjax('proportion-ajax',['ProportionArr'=>$ProportionArr]);
        } else {
            return $this->render('proportion');
        }
    }

}
