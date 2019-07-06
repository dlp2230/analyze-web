<?php
namespace backend\modules\pay\service;

use common\collections\Log;
use common\collections\log\LoginLog;
use common\collections\log\MoneyAddLog;
use common\collections\log\PayLog;
use common\collections\log\RegisterLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;
use backend\modules\gameuser\service\RoleService;
use common\models\CacheDayLog;
use common\models\CacheRecharge;
use common\models\ServerChannel;
use yii\data\Pagination;

class PayService extends Service
{
    /*
     * 新玩家价值
     * **/
    public function CountComsumption($game_id, $server_id, $channel_id, $day,$loseday = 7){
        switch($loseday){
            case 7:
                $contribution = CacheDayLog::SEVEN_DAY_CONTRIBUTION;
                break;
            case 14:
                $contribution = CacheDayLog::FOURTEEN_DAY_CONTRIBUTION;
                break;
            case 30:
                $contribution = CacheDayLog::THIRTY_DAY_CONTRIBUTION;
                break;
            default:
                break;
        }
        $data = [];
        /*
         *计算玩家价值
         * **/
        $contribution_num = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,$contribution);
        $role_num = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::REGISTER_ROLE_NUM);
        if($contribution_num && $role_num){
            if($contribution_num == 0 || $role_num == 0){
                $data = [
                    'pay_nums'=>0,
                    'reg_role'=>0,
                    'svg'=>0.00,
                ];
            }else{
                $data['pay_nums'] = $contribution_num;
                $data['reg_role'] = $role_num;
                $data['svg'] = sprintf("%.2f",($contribution_num / $role_num));
            }
            return $data;
        }

        //先查出这天注册数量
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::REGISTER,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $sts = $day + 86400*$loseday;
        $registerLogs = RegisterLog::find()
            ->where(RegisterLog::transArr($where))
            ->andWhere(['between', 'CP_create_time',
                RegisterLog::transKey('CP_create_time',$day) ,
                RegisterLog::transKey('CP_create_time',$day + 86400)])
            ->asArray()
            ->all();

        $role_id_arr = array_unique(array_column($registerLogs, 'role_id'));
        unset($registerLogs);
        //--新增角色
        $data['reg_role'] = count($role_id_arr);
        //查询之后的日期里面登录的
        $where['behavior'] =  Log::PAY;
        $PayLog = PayLog::find()->where(['in', 'role_id', PayLog::transArrWithKey('role_id',$role_id_arr)])
            ->andWhere(['between', 'timestamp',
                PayLog::transKey('timestamp',$day),
                PayLog::transKey('timestamp',$sts)])
            ->andWhere($where)
            ->asArray()->all();
        unset($role_id_arr);
        $data['pay_nums'] = array_sum(array_column($PayLog, 'CP_money'));
        unset($PayLog);

        if($data['pay_nums'] == 0){
            $data['svg'] = '0.00';
        }else{
            $data['svg'] = sprintf("%.2f", $data['pay_nums'] / $data['reg_role']);
        }
        /*
         *角色存在**
         * 并且当前时间大于7,14,30日
         * **/
        if(!empty($role_id_arr) && time() >= $sts){
            CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,$contribution,$data['pay_nums']);
        }
        return $data;
    }
    /*
     * 充值+赠送
     * **/
    public function CountRecharge($game_id, $server_id, $channel_id, $day){
        $newArr = CacheRecharge::getResult($day,$game_id, $server_id, $channel_id);
        //pay_cp_true_num and pay_cp_false_num
        if(!empty($newArr) && $newArr[CacheRecharge::$recharge_config[CacheRecharge::PAY_CP_TRUE_NUM]] !== null && $newArr[CacheRecharge::$recharge_config[CacheRecharge::PAY_CP_FALSE_NUM]] !== null && $newArr[CacheRecharge::$recharge_config[CacheRecharge::PAY_CP_MONEY]] !== null){
            return [
                'CP_true_num'  => $newArr[CacheRecharge::$recharge_config[CacheRecharge::PAY_CP_TRUE_NUM]],
                'CP_false_num' => $newArr[CacheRecharge::$recharge_config[CacheRecharge::PAY_CP_FALSE_NUM]],
                'CP_money' => $newArr[CacheRecharge::$recharge_config[CacheRecharge::PAY_CP_MONEY]],
            ];
        }

        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_ADD,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = PayLog::transArr($where);
        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $day);
        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $day + 86400);
        /*
         * 收入元宝 role_id 分组
         * **/
        $keys = array('game_id' => true);
        /*
         * 消耗通用货币 CP_true_num
         * 消耗绑定货币 CP_false_num
         * **/
        $initial = array("CP_true_num" => 0,'CP_false_num'=>0);
        $reduce = "function(obj,prev){ prev.CP_true_num +=obj.CP_true_num;prev.CP_false_num +=obj.CP_false_num;}";
        $data = MoneyAddLog::getCollection()->group($keys, $initial, $reduce, array('condition' => $where));
        /*
         * 查询充值表Pay 真币消耗 = CP_true_num + CP_money
         *  赠送币  = CP_false_num
         * ***/
        $where['behavior'] = Log::PAY;
        $keys = array('game_id' => true);
        $initial = array("CP_money" => 0,'CP_game_money'=>0);
        $reduce = "function(obj,prev){ prev.CP_money +=obj.CP_money;prev.CP_game_money +=obj.CP_game_money;}";
        $res = PayLog::getCollection()->group($keys, $initial, $reduce, array('condition' => $where));
        $arr = [];
        if(!empty($data) && !empty($res)) // 两者都存在
        {
            $arr['CP_money'] = $res[0]['CP_money'];
            $arr['CP_true_num'] = $data[0]['CP_true_num'] + $res[0]['CP_game_money'];
            $arr['CP_false_num'] = $data[0]['CP_false_num'];
        }elseif(!empty($data) && empty($res))
        {
            $arr['CP_money'] = 0;
            $arr['CP_true_num'] = $data[0]['CP_true_num'];
            $arr['CP_false_num'] = $data[0]['CP_false_num'];
        }elseif(empty($data) && !empty($res))
        {
            $arr['CP_money'] = $res[0]['CP_money'];
            $arr['CP_true_num'] = $res[0]['CP_game_money'];
            $arr['CP_false_num'] = 0;
        }else {
            $arr['CP_money'] = 0;
            $arr['CP_true_num'] = 0;
            $arr['CP_false_num'] = 0;
        }
        /*
         * 写入缓存
         * **/
        if(!empty($data) || !empty($res)){
            CacheRecharge::setResult($day,$game_id,$server_id,$channel_id,CacheRecharge::PAY_CP_TRUE_NUM,$arr['CP_true_num']);
            CacheRecharge::setResult($day,$game_id,$server_id,$channel_id,CacheRecharge::PAY_CP_FALSE_NUM,$arr['CP_false_num']);
            CacheRecharge::setResult($day,$game_id,$server_id,$channel_id,CacheRecharge::PAY_CP_MONEY,$arr['CP_money']);
        }
        return $arr;
    }
    /*
     * 订单列表-
     * ***/
    public function  getRegRmbDetail($start, $length, $where){
        $game_id = $where['game_id'];
        if(empty($game_id))
            return false;
        MongoHelper::setMongo($game_id);
        $where['behavior'] = Log::PAY;
        $sts = $where['start_time'];
        $ets = $where['end_time'];
        unset($where['start_time'],$where['end_time']);
        $where = PayLog::transArr($where);
        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $ets + 86400);
        return PayLog::find()->where($where)->orderBy('timestamp DESC')->limit($length)->offset($start)->asArray()->all();
    }
    public function getRegRmbDetailCount($where){
        $game_id = $where['game_id'];
        if(empty($game_id))
            return false;
        MongoHelper::setMongo($game_id);
        $where['behavior'] = Log::PAY;
        $sts = $where['start_time'];
        $ets = $where['end_time'];
        unset($where['start_time'],$where['end_time']);
        $where = PayLog::transArr($where);
        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $ets + 86400);
        return PayLog::find()->where($where)->count();
    }

    /*
     * GM赠送货币
     * **/
    public function getRegAdd($game_id, $server_id, $channel_id, $sts,$ets,$role_id){
        $data = [];
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::MONEY_ADD,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        if($role_id !=''){
            $where = array_merge($where, ['role_id' => $role_id]);
        }
        $where = MoneyAddLog::transArr($where);
        $where['timestamp']['$gte'] = MoneyAddLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  MoneyAddLog::transKey('timestamp', $ets + 86400);
        $data  = MoneyAddLog::find()->where($where)->orderBy('timestamp DESC')->asArray()->all();
        return $data;
    }
    /*
     *付费
     * **/
    public function CountRateTotal($game_id, $server_id, $channel_id, $day){
        $data = [];
        $data['login_nums'] = RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$day);
        if($data['login_nums'] !=0){
            $data['pay_nums'] = $this->getPayNum($game_id, $server_id, $channel_id, $day);
        }else{
            $data['pay_nums'] = 0;
        }
        if($data['login_nums'] == 0 || $data['pay_nums'] == 0){
            $data['svg'] = '0.00';
        }else{
            $data['svg'] = sprintf("%.2f",($data['pay_nums'] / $data['login_nums']*100));
        }

        return $data;
    }
    /*
     * Arpu
     * ***/
    public function countArpu($game_id, $server_id, $channel_id, $day){
        $data = [];
        $data['login_nums'] = RoleService::getInstance()->countActiveRoleNum($game_id,$server_id,$channel_id,$day);
        if($data['login_nums'] == 0){
            $data['svg'] = '0.00';
            $data['total'] = 0;
        }else{
            $data['total'] = $this->getPayTotal($game_id, $server_id, $channel_id, $day);
            $data['svg'] = sprintf("%.2f",($data['total'] / $data['login_nums']));
        }
         return $data;

    }
    /*
    * Arpu
    * ***/
    public function countArppu($game_id, $server_id, $channel_id, $day){
        $data = [];
        $data['pay_nums'] = $this->getPayNum($game_id, $server_id, $channel_id, $day);
        $data['total'] = $this->getPayTotal($game_id, $server_id, $channel_id, $day);
        if($data['pay_nums'] == 0){
            $data['svg'] = '0.00';
        }else{
            $data['svg'] = sprintf("%.2f",($data['total'] / $data['pay_nums']));
        }
        return $data;
    }

    /*
     * 新增付费用户
     * ***/
    public function CountPayAdd($game_id, $server_id, $channel_id, $day){
        $data = [];
        $data['pay_nums'] = $this->getPayNum($game_id, $server_id, $channel_id, $day);
        return $data;

    }
    /*
     * 付费付费频度
     * ***/
    public function CountFrequency($game_id, $server_id, $channel_id, $sts,$ets){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::PAY,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $ets + 86400);
        /*
         * 集合查询
         * **/
        $ops = [
           ['$match' => $where],
            ['$group' => ['_id' => '$role_id', 'num' => ['$sum' => 1],]]
        ];
        $PayLog = PayLog::getCollection()->aggregate($ops);
        return $PayLog;

    }

    /*
     *渠道付费
     * **/
    public function CountPayChannel($game_id, $server_id, $channel_id, $day){
        /*
         * 查询缓存
         * **/
        $PayLog = [];
       if($channel_id != ''){
           $pay_total = $this->getPayTotal($game_id, $server_id, $channel_id, $day);
           if($pay_total){
               $pay_nums  = $this->getPayNum($game_id, $server_id, $channel_id, $day);
               $PayLog = [
                   0=>[
                       '_id'=>[ 'channel_id'=>$channel_id],
                       'total'=>$pay_total,
                       'role_nums'=>$pay_nums,
                   ],
                   'paytoday'=>$pay_total,
               ];
           }

        }else{
           $list = ServerChannel::find()->where(['sid' => $server_id])->asArray()->all();
           $server_list = array_column($list, 'channel_id');
           foreach($server_list as $key=>$cid){
               $pay_total = $this->getPayTotal($game_id, $server_id, $cid, $day);
               if($pay_total){
                   $pay_nums  = $this->getPayNum($game_id, $server_id, $cid, $day);
                   $PayLog[$key] = [
                       '_id'=>[ 'channel_id'=>$cid],
                       'total'=>$pay_total,
                       'role_nums'=>$pay_nums,
                   ];
               }

           }
           unset($server_list);
           $PayLog['paytoday'] = array_sum(array_column($PayLog, 'total'));

        }

        return $PayLog;

//        MongoHelper::setMongo($game_id);
//        $where = [
//            'behavior' => Log::PAY,
//            'server_id' => intval($server_id),
//        ];
//        if ($channel_id != '') {
//            $where = array_merge($where, ['channel_id' => $channel_id]);
//        }
//        $where = PayLog::transArr($where);
//        /*
//         * 渠道分组哦
//         * ***/
//        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $day);
//        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $day + 86400);
//        $PayLog = [];
//        /*
//         * 集合查询
//         * **/
//        $ops =[
//            ['$match'=>$where],
//            ['$group' => ['_id' => ['channel_id'=>'$channel_id'],'total' => ['$sum' =>'$CP_money'],]],
//            ['$sort'=>['total'=> -1]],
//        ];
//        $PayLog = PayLog::getCollection()->aggregate($ops);
//
//        if(!empty($PayLog)){
//            if($channel_id != ''){
//                $role_nums = PayLog::getCollection()->distinct('role_id',$where);
//                $PayLog[0]['role_nums'] = count($role_nums);
//                unset($role_nums);
//            }else{
//                foreach($PayLog as &$item){
//                    $where['channel_id'] = $item['_id']['channel_id'];
//                    $role_nums = PayLog::getCollection()->distinct('role_id',$where);
//                    $item['role_nums'] = count($role_nums);
//                    unset($role_nums);
//                }
//            }
//            $PayLog['paytoday'] = array_sum(array_column($PayLog, 'total'));
//        }
//        return $PayLog;

    }

    /*
     * 付费排行榜
     * ***/
    public function CountRankList($game_id, $server_id, $channel_id, $sts,$ets,$ranking){
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::PAY,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = PayLog::transArr($where);
        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $ets + 86400);
        $ops = [
            ['$match' => $where],
            ['$group' => ['_id' => '$role_id', 'count' => ['$sum' => '$CP_money'],]],
            ['$sort'=>['count'=> -1]],
            ['$limit' => $ranking],
        ];
        $data = PayLog::getCollection()->aggregate($ops);
        if(!empty($data)){
            unset($where['behavior']);
            foreach($data as &$item){
                $where['role_id'] = $item['_id'];
                $result =  LoginLog::find()->where($where)->orderBy('timestamp DESC')->limit(1)->asArray()->all();
                $item['channel_id'] = $result[0]['channel_id'];
                $item['server_id'] = $result[0]['server_id'];
                $item['money_coin'] = $result[0]['money_coin'];
                $item['black_money'] = $result[0]['black_money'];
                $item['timestamp'] = $result[0]['timestamp'];
                $item['user_level'] = $result[0]['user_level'];

            }
        }
        return $data;
    }
    /*
     * 付费额度分布
     * ***/
    public function getQuotaDist($game_id, $server_id, $channel_id, $sts){
        $newArr = CacheDayLog::getResultOne($sts,$game_id,$server_id,$channel_id);
        if(!empty($newArr) && $newArr[CacheDayLog::$day_login_config[CacheDayLog::ONE_TO_TEN]] !== null && $newArr[CacheDayLog::$day_login_config[CacheDayLog::ELEVEN_TO_ONEHUNDRED]] !== null && $newArr[CacheDayLog::$day_login_config[CacheDayLog::HUNDREDONE_TO_FIVEHUNDRED]] !== null && $newArr[CacheDayLog::$day_login_config[CacheDayLog::FIVEHUNDRED_TO_ONETHOUSAND]] !== null && $newArr[CacheDayLog::$day_login_config[CacheDayLog::ONETHOUSAND_ABOVE]] !== null){
            return [
                'one'  => $newArr[CacheDayLog::$day_login_config[CacheDayLog::ONE_TO_TEN]],
                'ten' => $newArr[CacheDayLog::$day_login_config[CacheDayLog::ELEVEN_TO_ONEHUNDRED]],
                'one_hundred' => $newArr[CacheDayLog::$day_login_config[CacheDayLog::HUNDREDONE_TO_FIVEHUNDRED]],
                'five_hundred' => $newArr[CacheDayLog::$day_login_config[CacheDayLog::FIVEHUNDRED_TO_ONETHOUSAND]],
                'one_thousand' => $newArr[CacheDayLog::$day_login_config[CacheDayLog::ONETHOUSAND_ABOVE]],
            ];
        }

        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::PAY,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $where = PayLog::transArr($where);
        $where['timestamp']['$gte'] = PayLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  PayLog::transKey('timestamp', $sts + 86400);
        $ops = [
            ['$match' => $where],
            ['$group' => ['_id' => ['Cp_money'=>'$CP_money'], 'count' => ['$sum' => 1],]],
        ];
        $data = PayLog::getCollection()->aggregate($ops);
        $res =['one' => 0, 'ten' => 0, 'one_hundred'=>0, 'five_hundred' =>0, 'one_thousand' =>0];
        if(!empty($data)){
            foreach($data as $item){
                $Cp_money = $item['_id']['Cp_money'];
                switch ($Cp_money){
                    case $Cp_money>='1' && $Cp_money<='10': $res['one'] += $item['count']; break;
                    case $Cp_money>='11' && $Cp_money<='100': $res['ten'] += $item['count']; break;
                    case $Cp_money>='101' && $Cp_money<='500': $res['one_hundred'] += $item['count']; break;
                    case $Cp_money>='501' && $Cp_money<='1000': $res['five_hundred'] +=$item['count']; break;
                    case $Cp_money>'1000': $res['one_thousand'] +=$item['count']; break;
                }
            }
            CacheDayLog::setResult($sts,$game_id,$server_id,$channel_id,CacheDayLog::ONE_TO_TEN,$res['one']);
            CacheDayLog::setResult($sts,$game_id,$server_id,$channel_id,CacheDayLog::ELEVEN_TO_ONEHUNDRED,$res['ten']);
            CacheDayLog::setResult($sts,$game_id,$server_id,$channel_id,CacheDayLog::HUNDREDONE_TO_FIVEHUNDRED,$res['one_hundred']);
            CacheDayLog::setResult($sts,$game_id,$server_id,$channel_id,CacheDayLog::FIVEHUNDRED_TO_ONETHOUSAND,$res['five_hundred']);
            CacheDayLog::setResult($sts,$game_id,$server_id,$channel_id,CacheDayLog::ONETHOUSAND_ABOVE,$res['one_thousand']);
        }
        return $res;
    }
   /*
    * getList
    * ***/
    public function getList($start, $length, $where){
        $parm = $_REQUEST+$_SESSION;
        $game_id = isset($parm['game_id'])?$parm['game_id']:0;
        MongoHelper::setMongo($game_id);
        $server_id  = isset($parm['server'])?$parm['server']:0;
        $channel_id = isset($parm['channel'])?$parm['channel']:0;
        $role_id = !empty($parm['role_id'])?$parm['role_id']:'';
        $sts = isset($parm['start_time']) ? strtotime($parm['start_time']) : strtotime(date('Y-m-d'));
        $ets = isset($parm['end_time']) ? strtotime($parm['end_time']) : strtotime(date('Y-m-d 23:59:59'));
        $where = [
            'behavior' => Log::MONEY_ADD,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        if($role_id !='' ){
            $where = array_merge($where, ['role_id' => $role_id]);
        }
        $where = MoneyAddLog::transArr($where);
        $where['timestamp']['$gte'] = MoneyAddLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  MoneyAddLog::transKey('timestamp', $ets + 86400);
        return MoneyAddLog::find()->where($where)->limit($length)->offset($start)->asArray()->all();

    }
    public function getListCount($where)
    {
        $parm = $_GET+$_SESSION;
        $game_id = isset($parm['game_id'])?$parm['game_id']:0;
        MongoHelper::setMongo($game_id);
        $server_id  = isset($parm['server'])?$parm['server']:0;
        $channel_id = isset($parm['channel'])?$parm['channel']:0;
        $role_id = !empty($parm['role_id'])?$parm['role_id']:'';
        $sts = isset($parm['start_time']) ? strtotime($parm['start_time']) : strtotime(date('Y-m-d'));
        $ets = isset($parm['end_time']) ? strtotime($parm['end_time']) : strtotime(date('Y-m-d 23:59:59'));
        $where = [
            'behavior' => Log::MONEY_ADD,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        if($role_id !='' ){
            $where = array_merge($where, ['role_id' => $role_id]);
        }
        $where = MoneyAddLog::transArr($where);
        $where['timestamp']['$gte'] = MoneyAddLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  MoneyAddLog::transKey('timestamp', $ets + 86400);
        $data = MoneyAddLog::find()->where($where)->count();
        return $data;
    }
    /*
     * 付费用户数
     * **/
    private function getPayNum($game_id, $server_id, $channel_id, $day){
        $pay_nums = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::PAY_NUMS);

        if($pay_nums !== false){
            return $pay_nums;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::PAY,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }

        $PayLog = PayLog::find()->where(PayLog::transArr($where))->andWhere(['between', 'timestamp', PayLog::transKey('timestamp', $day), PayLog::transKey('timestamp', $day + 86400)])->asArray()->all();
        /*
        *支付用户数
        * **/
        $pay_nums = count(array_unique(array_column($PayLog, 'role_id')));
        unset($PayLog);
        if($pay_nums != 0 ){
            CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::PAY_NUMS,$pay_nums);
        }
        return $pay_nums;

    }

    /*
     * 付费总金额
     * **/
    private function getPayTotal($game_id, $server_id, $channel_id, $day){
        $pay_total = CacheDayLog::getResultOne($day,$game_id,$server_id,$channel_id,CacheDayLog::PAY_TOTAL);
        if($pay_total !== false){
            return $pay_total;
        }
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => Log::PAY,
            'server_id' => intval($server_id),
        ];
        if ($channel_id != '') {
            $where = array_merge($where, ['channel_id' => $channel_id]);
        }
        $PayLog = PayLog::find()->where(PayLog::transArr($where))->andWhere(['between', 'timestamp', PayLog::transKey('timestamp', $day), PayLog::transKey('timestamp', $day + 86400)])->asArray()->all();
        /*
        *支付用户数
        * **/
        $pay_total = array_sum(array_column($PayLog, 'CP_money'));
        unset($PayLog);
        if(!empty($PayLog)){
            CacheDayLog::setResult($day,$game_id, $server_id, $channel_id,CacheDayLog::PAY_TOTAL,$pay_total);
        }
        return $pay_total;

    }




}