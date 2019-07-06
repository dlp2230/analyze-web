<?php
namespace frontend\service;
use common\collections\Log;
use common\collections\log\RegisterLog;
use common\collections\log\LoginLog;
use common\collections\log\PayLog;
use common\collections\log\MoneyAddLog;
use common\collections\log\MoneyCostLog;
use common\collections\log\MoneyMinusLog;
use common\collections\log\GoldAddLog;
use common\collections\log\GoldCostLog;
use common\collections\log\GoldMinusLog;
use common\libraries\base\Service;
use common\helpers\MongoHelper;


class DebugService extends Service
{
    const Limit = 10;
    public function show($arr1,$arr2){
        $a =[];
        foreach($arr1 as $k=>$v){
            $a [$k] = $arr2[$v];
        }
        return $a;
    }
    //注册接口
    public function getRegisterData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $registerLogs = RegisterLog::find()
            ->where(registerLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($registerLogs)){
            foreach ($registerLogs as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$registerLogs[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 上下线
     * **/
    public function getLogingData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::LOGIN,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = LoginLog::find()
            ->where(LoginLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 支付
     * ***/
    public function getPayData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::PAY,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = PayLog::find()
            ->where(PayLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 元宝非充值加币
     * ***/
    public function getMoneyAddData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_ADD,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = MoneyAddLog::find()
            ->where(MoneyAddLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 元宝消费
     * **/
    public function getMoneyCostData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_COST,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = MoneyCostLog::find()
            ->where(MoneyCostLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 元宝消费
     * **/
    public function getMoneyMinusData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_MINUS,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = MoneyMinusLog::find()
            ->where(MoneyMinusLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 金币加币
     * **/
    public function getGoldAddData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::GOLD_ADD,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = GoldAddLog::find()
            ->where(GoldAddLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 金币消费
     * ***/
    public function getGoldCostData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::GOLD_COST,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = GoldCostLog::find()
            ->where(GoldCostLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }
    /*
     * 金币非正常扣除
     * ***/
    public function getGoldMinusData($game_id,$server_id,$role_id,$behavior){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::GOLD_MINUS,
            'server_id' => $server_id,
            'role_id'=>$role_id,
        ];
        $data = GoldMinusLog::find()
            ->where(GoldMinusLog::transArr($where))
            ->limit(self::Limit)
            ->orderBy('timestamp desc')
            ->asArray()
            ->all();
        $newArr = [];
        if(!empty($data)){
            foreach ($data as $key=>$item) {
                $newArr[$key] = $this->show(ConfigService::getInstance()->fieldArr($behavior),$data[$key]);
            }
        }
        return $newArr;
    }


}