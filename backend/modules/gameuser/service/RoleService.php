<?php
namespace backend\modules\gameuser\service;

use common\collections\Log;
use common\collections\log\LoginLog;
use common\collections\log\RegisterLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;
use common\models\CacheDayLog;

class RoleService extends Service
{

    /**
     * 查询新增角色数量
     */
    public function countRegRoleNum($game_id, $server_id, $channel_id, $day)
    {
        $res = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::REGISTER_ROLE_NUM);
        if($res !==false){
            return $res;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
            'server_id' => $server_id,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $registerLogs = RegisterLog::find()
            ->where(registerLog::transArr($where))
            ->andWhere(['between', 'CP_create_time', RegisterLog::transKey('CP_create_time', $day), RegisterLog::transKey('CP_create_time', $day + 86400)])->asArray()
            ->all();

        if(empty($registerLogs)){
            return 0;
        }
        $count = count($registerLogs);
        CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::REGISTER_ROLE_NUM,$count);
        return $count;

    }

    /**
     * 查询活跃角色数量,只算登录的用户
     */
    public function countActiveRoleNum($game_id, $server_id, $channel_id, $day)
    {
        $res = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::ACTIVE_ROLE_NUM);
        if($res !== false){
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
        $where = LoginLog::transArr($where);
        $where['timestamp']['$gte'] = LoginLog::transKey('timestamp', $day);
        $where['timestamp']['$lt'] =  LoginLog::transKey('timestamp', $day + 86400);
        $role_id_arr = LoginLog::getCollection()->distinct('role_id',$where);
        if(empty($role_id_arr)){
            return 0;
        }
        $count = count($role_id_arr);
        CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::ACTIVE_ROLE_NUM,$count);
        return $count;

    }
    /*
     *查询新增设备号
     * **/
    public function countDeviceNum($game_id, $server_id, $channel_id, $day)
    {
        $res = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::REGISTER_DEVICE_NUM);
        if($res !==false){
            return $res;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
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
        $count = count(array_unique(array_column($loginLogs, 'device')));
        CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::REGISTER_DEVICE_NUM,$count);
        return $count;
    }


}