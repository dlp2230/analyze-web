<?php
namespace backend\modules\gameuser\service;

use common\collections\Log;
use common\collections\log\LoginLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;
use common\models\CacheDayLog;


class ActiveService extends Service
{

    /*
     *每日活跃玩家总次数
     * **/
    public function countActiveNumDays($game_id, $server_id, $channel_id, $day)
    {
        $res = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::ACTIVE_GAME_NUM);
        if($res !==false){
            return $res;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::LOGIN,
            'server_id' => $server_id,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $loginLogs = LoginLog::find()
            ->where(LoginLog::transArr($where))
            ->andWhere(['between', 'timestamp', LoginLog::transKey('timestamp', $day), LoginLog::transKey('timestamp', $day + 86400)])->asArray()
            ->all();
        if(empty($loginLogs)){
            return 0;
        }
        $count = count(array_column($loginLogs, '_id'));
        CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::ACTIVE_GAME_NUM,$count);
        return $count;
    }
    /*
     * 活跃玩家总时长
     * **/
    public function CountActiveOnline($game_id, $server_id, $channel_id, $day){
        $res = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::ACTIVE_GAME_TIME);
        if($res !==false){
            return $res;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::LOGIN,
            'server_id' => intval($server_id),
       ];

        if ($channel_id != '') {
           $where = array_merge($where, ['channel_id' => intval($channel_id)]);
        }
        $where = LoginLog::transArr($where);
       $where['timestamp'] = ['$gte'=>$day,'$lt'=>($day + 86400)];
       $data = [
            ['$match' => $where],
            ['$group' => ['_id' => 0, 'count' => [ '$sum' => '$CP_online_time' ]]]
       ];
       $loginLogs = LoginLog::getCollection()->aggregate($data);
        if(empty($loginLogs)){
            return 0;
        }
        $count = isset($loginLogs[0]['count']) ? $loginLogs[0]['count'] : 0;
        CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::ACTIVE_GAME_TIME,$count);
        return $count;
    }
    /**
    **/
    public function CountActiveLoss($game_id, $server_id, $channel_id, $day,$loseday = 0){
        ini_set('memory_limit', '512M');
        switch($loseday){
            case 7:
                $loss_config = CacheDayLog::SEVEN_DAY_LOSS;
                $active_config = CacheDayLog::SEVEN_DAY_ACTIVE;
                break;
            case 14:
                $loss_config = CacheDayLog::FOURTEEN_DAY_LOSS;
                $active_config = CacheDayLog::FOURTEEN_DAY_ACTIVE;
                break;
            case 30:
                $loss_config = CacheDayLog::THIRTY_DAY_LOSS;
                $active_config = CacheDayLog::THIRTY_DAY_ACTIVE;
                break;
            default:
                break;
        }
        $data = [];
        /*
         *计算流失
         * **/
        $loss_nums = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,$loss_config);
        $active_nums = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,$active_config);
        if($loss_nums !==false && $active_nums !==false){
            if($active_nums == 0 || $loss_nums == 0){
                $data = [
                    'active_nums'=>0,
                    'loss_user'=>0,
                    'svg'=>0.00,
                ];
            }else{
                $data['active_nums'] = $active_nums;
                $data['loss_user'] = $loss_nums;
                $data['svg'] = sprintf("%.2f",($loss_nums / $active_nums*100));
            }
            return $data;
        }

       //先查出这天注册数量
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::LOGIN,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => intval($channel_id)]);
        }
        $sts = $day - 86400*$loseday;
        $where = LoginLog::transArr($where);
        $where['timestamp']['$gte'] = LoginLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  LoginLog::transKey('timestamp', $sts + 86400);
        /*
         * 活跃用户 7,14,30 前的活跃用用户
         * **/
        $role_id_arr = LoginLog::getCollection()->distinct('role_id',$where);
        $data['active_nums'] = count($role_id_arr);
        /*
         *$in 得到活跃用户数
         * 流失用户数 = 活跃用户数(7,14,30日前)  - 活跃用户用户数
         * ***/
        $where['role_id']['$in'] = LoginLog::transArrWithKey('role_id',$role_id_arr);
        $where['timestamp']['$gte'] = LoginLog::transKey('timestamp', $sts + 86400);
        $where['timestamp']['$lt'] =  LoginLog::transKey('timestamp', $day + 86400);

        unset($role_id_arr);
        $loginLog_arr = LoginLog::getCollection()->distinct('role_id',$where);
        /*
         * 时间范围活跃数
         * **/
        if(!empty($loginLog_arr)){
            $role_active_num = count($loginLog_arr);
        }else{
            $role_active_num = 0;
        }
        unset($loginLog_arr);
        $data['loss_user'] = $data['active_nums'] - $role_active_num;
        if($data['active_nums'] == 0 || $data['loss_user']==0){
            $data['svg'] = '0.00';
        }else{
            $data['svg'] = sprintf("%.2f",($data['loss_user'] / $data['active_nums']*100));
        }
        if($data['active_nums'] != 0){
            CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,$loss_config,$data['loss_user']);
            CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,$active_config,$data['active_nums']);
        }

        return $data;
    }
}