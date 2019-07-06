<?php
namespace backend\modules\gameuser\service;

use common\collections\Log;
use common\collections\log\LoginLog;
use common\collections\log\RegisterLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;
use common\models\CacheRetainedRole;
use common\models\CacheRetainedDevice;


class RetentionService extends Service
{
    public function test()
    {

        $data = LoginLog::getCollection();
        ee($data);

    }

    //计算留存率
    //$game_id
    //$server_id
    //$channel_id
    //$day
    //$dayNum   //计算某一天的几日留存   次日留存 $dayNum=2
    public function countRetention($game_id, $server_id, $channel_id, $day, $dayNum)
    {

        $res = CacheRetainedRole::getRole($day,$game_id, $server_id, $channel_id,$dayNum);
        if($res !==false){
           return $res;
        }
        $time_today = strtotime(date('Y-m-d', time()));
        if ($day + ($dayNum - 1) * 86400 > $time_today) {
            //留存率不存在
            return '0.00';
        }
        //先查出这天注册数量
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
            'server_id' => $server_id,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }

        $where = RegisterLog::transArr($where);
        $where['CP_create_time']['$gte'] = RegisterLog::transKey('CP_create_time', $day);
        $where['CP_create_time']['$lt'] =  RegisterLog::transKey('CP_create_time', $day + 86400);
        /*
         * 活跃用户 7,14,30 前的活跃用用户
         * **/
        $role_id_arr = RegisterLog::getCollection()->distinct('role_id',$where);
        unset($where['CP_create_time']);
        if (count($role_id_arr) == 0) {
            return '0.00';           //当天没有人注册
        }
         //查询之后的日期里面登录的
       $where['behavior'] = Log::LOGIN;
        $loginLog = LoginLog::find()->where(['in', 'role_id', LoginLog::transArrWithKey('role_id',$role_id_arr)])
           ->andWhere(['between', 'timestamp',
                LoginLog::transKey('timestamp',$day + ($dayNum-1) * 86400),
                LoginLog::transKey('timestamp',$day + $dayNum * 86400)])
            ->andWhere(LoginLog::transArr($where))
            ->asArray()->all();
        $loginLog_arr = array_unique(array_column($loginLog, 'role_id'));

        if(count($loginLog_arr) == 0 || count($role_id_arr) == 0){
            $retentionCount = 0.00;
        }else{
            $retentionCount = sprintf("%.2f",(count($loginLog_arr) / count($role_id_arr)*100));
        }
        CacheRetainedRole::setRole($day,$game_id, $server_id, $channel_id,$dayNum,$retentionCount);
        return $retentionCount;
    }
    /*
     * 设备liucun
     * ***/
    public function countRetentionDevice($game_id, $server_id, $channel_id, $day, $dayNum)
    {
        $res = CacheRetainedDevice::getDevice($day,$game_id, $server_id, $channel_id,$dayNum);
        if($res !==false){
            return $res;
        }
        $time_today = strtotime(date('Y-m-d', time()));
        if ($day + ($dayNum - 1) * 86400 > $time_today) {
            //留存率不存在
            return '0.00';
        }
        //先查出这天注册数量
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
            'server_id' => $server_id,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }


        $where = RegisterLog::transArr($where);
        $where['CP_create_time']['$gte'] = RegisterLog::transKey('CP_create_time', $day);
        $where['CP_create_time']['$lt'] =  RegisterLog::transKey('CP_create_time', $day + 86400);
        /*
         * 活跃用户 7,14,30 前的活跃用用户
         * **/
        $role_id_arr = RegisterLog::getCollection()->distinct('device',$where);
        unset($where['CP_create_time']);
        if (count($role_id_arr) == 0) {
            return '0.00';           //当天没有人注册
        }
        //查询之后的日期里面登录的
        $where['behavior'] = Log::LOGIN;
        $loginLog = LoginLog::find()->where(['in', 'device', LoginLog::transArrWithKey('device',$role_id_arr)])
            ->andWhere(['between', 'timestamp',
                LoginLog::transKey('timestamp',$day + ($dayNum-1) * 86400),
                LoginLog::transKey('timestamp',$day + $dayNum * 86400)])
            ->andWhere(LoginLog::transArr($where))
            ->asArray()->all();
        $loginLog_arr = array_unique(array_column($loginLog, 'device'));
        if(count($loginLog_arr) == 0 || count($role_id_arr) == 0){
            $retentionCount = 0.00;
        }else{
            $retentionCount = sprintf("%.2f",(count($loginLog_arr) / count($role_id_arr)*100));
        }
        CacheRetainedDevice::setDevice($day,$game_id, $server_id, $channel_id,$dayNum,$retentionCount);
        return $retentionCount;
    }
}