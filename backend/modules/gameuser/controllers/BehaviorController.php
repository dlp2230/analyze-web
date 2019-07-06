<?php
namespace backend\modules\gameuser\controllers;
use backend\libraries\base\Controller;
use backend\modules\gameuser\service\RoleService;
use backend\modules\gameuser\service\ActiveService;
use backend\helpers\Tool;
use Yii;

/**
 * Perm controller
 */
class BehaviorController extends Controller
{
    /*
     * 活跃玩家游戏次数
     * **/
    public function actionActiveNums()
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
                $ProportionArr[$v]['active_nums'] = ActiveService::getInstance()->countActiveNumDays($game_id,$server_id,$channel_id,$time);
                $ProportionArr[$v]['active'] = RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$time);
                if($ProportionArr[$v]['active'] == 0 || $ProportionArr[$v]['active_nums']==0){
                    $ProportionArr[$v]['svg'] = 0;
                }else{
                    $ProportionArr[$v]['svg'] = round($ProportionArr[$v]['active_nums']/$ProportionArr[$v]['active']);
                }
            }
           return $this->renderAjax('activenums-ajax',['ProportionArr'=>$ProportionArr]);
        } else {
            return $this->render('activenums');
        }
    }
    /*
     * 活跃玩家平圴时长
     * 日期范围内每日的活跃玩家时长求和/该日活跃玩家数量【粒度：秒】=该日活跃用户平均有游戏时长
     * 2016-04-18 pm dlx
     *
     * **/
    public function actionActiveOnline()
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
                $ProportionArr[$v]['active_online'] = ActiveService::getInstance()->CountActiveOnline($game_id,$server_id,$channel_id,$time);
                $ProportionArr[$v]['active_nums'] = RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$time);
                if($ProportionArr[$v]['active_online'] == 0 || $ProportionArr[$v]['active_nums'] == 0){
                    $ProportionArr[$v]['svg'] = 0;
                }else{
                    $ProportionArr[$v]['svg'] = ceil(($ProportionArr[$v]['active_online']/$ProportionArr[$v]['active_nums']) / 60);
                }
            }
            return $this->renderAjax('activeonline-ajax',['ProportionArr'=>$ProportionArr]);
        } else {
            return $this->render('activeonline');
        }
    }

}
