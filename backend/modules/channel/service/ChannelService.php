<?php
namespace backend\modules\channel\service;

use common\collections\Log;
use common\collections\log\MoneyAddLog;
use common\collections\log\PayLog;
use common\collections\log\LoginLog;
use common\collections\log\RegisterLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;
use common\models\CacheChannelDayLog;
use common\models\Server;
use yii\helpers\ArrayHelper;


class ChannelService extends Service
{
    public function countRole($game_id,$channel_id,$start_time){
        $res=CacheChannelDayLog::countRole($game_id,$channel_id,$start_time,CacheChannelDayLog::NEW_ROLE);
        if(!empty($res['new_role'])&&$res){
            $list = self::serverName($res,$game_id);
            return $list;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where=registerLog::transArr($where);
        $where['CP_create_time']['$gte'] = registerLog::transKey('CP_create_time', $start_time);
        $where['CP_create_time']['$lt'] =  registerLog::transKey('CP_create_time', $start_time + 86400);
        $class=[
            ['$match' => $where],
            ['$group' => ['_id' => '$server_id','new_role' =>['$sum' => 1]]],
            ['$sort'=>['_id'=> 1]],
        ];
        $registerLogs=PayLog::getCollection()->aggregate($class);
        if(!empty($registerLogs)){
            foreach($registerLogs as &$value){
                $value['server_id'] = $value['_id'];
                unset($value['_id']);
            }
            CacheChannelDayLog::setRoleResult($registerLogs,$game_id,$channel_id,$start_time,$type);
            $list = self::serverName($registerLogs,$game_id);
        }else{
            $list=false;
        }
        return $list;
    }

    public function countDevice($game_id,$channel_id,$start_time){
        $res=CacheChannelDayLog::countRole($game_id,$channel_id,$start_time,CacheChannelDayLog::NEW_DEVICE);
        if(!empty($res['new_device'])&&$res){
            $list = self::serverName($res,$game_id);
            return $list;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where=registerLog::transArr($where);
        $where['timestamp']['$gte'] = registerLog::transKey('timestamp', $start_time);
        $where['timestamp']['$lt'] =  registerLog::transKey('timestamp', $start_time + 86400);
        $class=[
            ['$match' => $where],
            ['$group' => ['_id' => [ 'server_id'=>'$server_id','device'=>'$device']]],
            ['$group' => ['_id' => '$_id.server_id','new_device' => ['$sum' => 1 ]]],
            ['$sort'=>['server_id'=> 1]],
        ];
        $loginLogs=PayLog::getCollection()->aggregate($class);
        if(!empty($loginLogs)){
            foreach($loginLogs as &$value){
                $value['server_id'] = $value['_id'];
                unset($value['_id']);
            }
            CacheChannelDayLog::setRoleResult($loginLogs, $game_id, $channel_id, $start_time,$type);
            $device = self::serverName($loginLogs,$game_id);
        }else{
            $device=false;
        }
        return $device;
    }

    public function getPayMan($game_id,$channel_id,$start_time){
        $res=CacheChannelDayLog::countRole($game_id,$channel_id,$start_time,CacheChannelDayLog::PAY_MAN);
        if(!empty($res['new_device'])&&$res){
            $list = self::serverName($res,$game_id);
            return $list;
        }
        MongoHelper::setMongo($game_id);
        $where=[
            'behavior' => Log::PAY,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = PayLog::transArr($where);
        $where['timestamp']['$gte'] = registerLog::transKey('timestamp', $start_time);
        $where['timestamp']['$lt'] =  registerLog::transKey('timestamp', $start_time + 86400);
        $class=[
            ['$match' => $where],
            ['$group' => ['_id' => [ 'server_id'=>'$server_id','role_id'=>'$role_id']]],
            ['$group' => ['_id' => '$_id.server_id','pay_man' => ['$sum' => 1 ]]],
            ['$sort'=>['server_id'=> 1]],
        ];
         $payman=PayLog::getCollection()->aggregate($class);
        if(!empty($payman)){
            foreach($payman as &$value){
                $value['server_id'] = $value['_id'];
                unset($value['_id']);
            }
            CacheChannelDayLog::setRoleResult($payman, $game_id, $channel_id, $start_time,$type);
            $pay_man = self::serverName($payman,$game_id);
        }else{
            $pay_man = false;
        }
        return $pay_man;
    }

    public function getPaySum($game_id,$channel_id,$start_time){
        $res=CacheChannelDayLog::countRole($game_id,$channel_id,$start_time,CacheChannelDayLog::CP_MONEY);
        if(!empty($res['new_device'])&&$res){
            $list = self::serverName($res,$game_id);
            return $list;
        }
        MongoHelper::setMongo($game_id);
        $where=[
            'behavior' => Log::PAY,
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where=PayLog::transArr($where);
        $where['timestamp']['$gte'] = registerLog::transKey('timestamp', $start_time);
        $where['timestamp']['$lt'] =  registerLog::transKey('timestamp', $start_time + 86400);
        $class=[
            ['$match' => $where],
            ['$group' => ['_id' => '$server_id','CP_money' =>['$sum' => '$CP_money']]],
            ['$sort'=>['_id'=> 1]],
        ];
        $sum=PayLog::getCollection()->aggregate($class);
        if(!empty($sum)){
            foreach($sum as &$value){
                $value['server_id'] = $value['_id'];
                unset($value['_id']);
            }
            CacheChannelDayLog::setRoleResult($sum,$game_id,$channel_id,$start_time,$type);
            $list = self::serverName($sum,$game_id);
        }else{
            $list=false;
        }
        return $list;
    }


    static function serverName($registerLogs,$game_id){
        $server=ArrayHelper::map(Server::find()->select(['sid','name'])->where(['game_id'=>$game_id])->asArray()->all(),'sid','name');
        foreach($registerLogs as &$value){
            $value['server_name']=isset($server[$value['server_id']]) ? $server[$value['server_id']] : $value['server_id'];
        }
        return $registerLogs;
    }
}