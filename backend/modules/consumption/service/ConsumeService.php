<?php
namespace backend\modules\consumption\service;

use common\collections\Log;
use common\collections\log\MoneyCostLog;
use common\collections\log\GoldCostLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;
use common\models\CacheRecharge;
use common\models\CacheMoneyCost;
use common\models\CacheGoldCost;


class ConsumeService extends Service
{
    /*
     * 充值+赠送
     * **/
    public function CountRegGive($game_id, $server_id, $channel_id, $day){
        $newArr = CacheRecharge::getResult($day,$game_id,$server_id,$channel_id);
        if(!empty($newArr) && $newArr[CacheRecharge::$recharge_config[CacheRecharge::CONSUMPTION_CP_TRUE_NUM]] !== null && $newArr[CacheRecharge::$recharge_config[CacheRecharge::CONSUMPTION_CP_FALSE_NUM]] !== null && $newArr[CacheRecharge::$recharge_config[CacheRecharge::CONSUMPTION_CP_MONEY]] !== null){
            return [
                'CP_price'  => $newArr[CacheRecharge::$recharge_config[CacheRecharge::CONSUMPTION_CP_MONEY]],
                'CP_true_num' => $newArr[CacheRecharge::$recharge_config[CacheRecharge::CONSUMPTION_CP_TRUE_NUM]],
                'CP_false_num' => $newArr[CacheRecharge::$recharge_config[CacheRecharge::CONSUMPTION_CP_FALSE_NUM]],
            ];
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_COST,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = MoneyCostLog::transArr($where);
        $where['timestamp']['$gte'] = MoneyCostLog::transKey('timestamp', $day);
        $where['timestamp']['$lt'] =  MoneyCostLog::transKey('timestamp', $day + 86400);
        $keys = ['game_id'=>null];
        $initial = array('CP_price'=>0,'CP_true_num'=>0,'CP_false_num'=>0);
        $reduce = "function(obj,prev){prev.CP_price +=obj.CP_price;prev.CP_true_num +=obj.CP_true_num;prev.CP_false_num +=obj.CP_false_num;}";
        /*
         * 消费充值币额度
         * **/
         $data = MoneyCostLog::getCollection()->group($keys, $initial, $reduce, array('condition' => $where));
         if(empty($data)){
             $data[0]['CP_price'] = 0;
             $data[0]['CP_true_num'] = 0;
             $data[0]['CP_false_num'] = 0;
         }else{
             CacheRecharge::setResult($day,$game_id,$server_id,$channel_id,CacheRecharge::CONSUMPTION_CP_MONEY,$data[0]['CP_price']);
             CacheRecharge::setResult($day,$game_id,$server_id,$channel_id,CacheRecharge::CONSUMPTION_CP_TRUE_NUM,$data[0]['CP_true_num']);
             CacheRecharge::setResult($day,$game_id,$server_id,$channel_id,CacheRecharge::CONSUMPTION_CP_FALSE_NUM,$data[0]['CP_false_num']);
         }
         return $data[0];


    }

    /*
     * 元宝消耗
     * ***/
    public function getChannelDetail($game_id, $server_id, $channel_id,$day){
        $res = CacheMoneyCost::getResult($day,$game_id,$server_id,$channel_id);
        if($res){
           return $res;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_COST,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = MoneyCostLog::transArr($where);
        $where['timestamp']['$gte'] = MoneyCostLog::transKey('timestamp', $day);
        $where['timestamp']['$lt'] =  MoneyCostLog::transKey('timestamp', $day + 86400);
        /*
         * 消费类型分组
         * **/
        $keys = array('CP_type' => true);
        $initial = array("count" => 0);
        $reduce = "function(obj,prev){ prev.count +=obj.CP_price;}";
        $data = MoneyCostLog::getCollection()->group($keys, $initial, $reduce, array('condition' => $where));

        $flag = [];
        if(!empty($data)){
            foreach($data as $item){
                $flag[]=$item["count"];
                CacheMoneyCost::setResult($day,$game_id,$server_id,$channel_id,$item['CP_type'],$item['count']);
            }
        }
        array_multisort($flag, SORT_DESC, $data);
        return $data;
    }
  /*
   * 金币消耗
   * **/

    public function getGold($game_id, $server_id, $channel_id, $day){
        $res = CacheGoldCost::getResult($day,$game_id,$server_id,$channel_id);
        if($res){
            return $res;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::GOLD_COST,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = GoldCostLog::transArr($where);
        $where['timestamp']['$gte'] = GoldCostLog::transKey('timestamp', $day);
        $where['timestamp']['$lt'] =  GoldCostLog::transKey('timestamp', $day + 86400);
        /*
         * 消费类型分组
         * **/
        $keys = array('CP_type' => true);
        $initial = array("count" => 0);
        $reduce = "function(obj,prev){ prev.count +=obj.CP_price;}";
        $data = GoldCostLog::getCollection()->group($keys, $initial, $reduce, array('condition' => $where));
        $flag = [];
        if(!empty($data)){
            foreach($data as &$item){
                $flag[]=$item["count"];
                CacheGoldCost::setResult($day,$game_id,$server_id,$channel_id,$item['CP_type'],$item['count']);
            }

        }
        array_multisort($flag, SORT_DESC, $data);
        return $data;
    }
    /*
  * 消费排行榜
  * ***/
    public function getConsumptionTop($game_id, $server_id, $channel_id, $sts,$ets,$ranking=50){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_COST,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = MoneyCostLog::transArr($where);
        $where['timestamp']['$gte'] = MoneyCostLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  MoneyCostLog::transKey('timestamp', $ets + 86400);
        $data = [
            [
                '$match'=>$where
            ],
            [
                '$group' => [
                    '_id' => ['role_id'=>'$role_id'],
                    'count' => [ '$sum' => '$CP_true_num'],
                    'channel_id'=>['$last'=>'$channel_id'],
                    'server_id'=>['$last'=>'$server_id'],
                    'user_level'=>['$last'=>'$user_level'],
                    'timestamp'=>['$last'=>'$timestamp'],
                ]
            ],
            [
                '$sort'=>['count'=>-1]
            ],
            [
                '$limit'=>$ranking
            ]

        ];
        $data = MoneyCostLog::getCollection()->aggregate($data);
        return $data;
    }



}