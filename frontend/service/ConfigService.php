<?php
namespace frontend\service;
use common\collections\Log;
use common\libraries\base\Service;


class ConfigService extends Service
{
    public static $behavior_type = [
        Log::REGISTER =>'注册',
        Log::LOGIN =>'上下线',
        Log::PAY =>'(元宝)充值加币',
        Log::MONEY_ADD =>'(元宝)非充值加币',
        Log::MONEY_COST =>'(元宝)消费',
        Log::MONEY_MINUS =>'(元宝)非正常扣除',
        Log::GOLD_ADD =>'(金币)加币',
        Log::GOLD_COST =>'(金币)消费',
        Log::GOLD_MINUS =>'(金币)非正常扣除',
    ];
    /*
     * 字段映射，字段说明，验证，例子**/
    public $configArr1 = [
        'field'=>[],
        'fieldMap'=>[],
        'verif'=>[],
        'example'=>[],
    ];
    /*
    * 字段映射，字段说明，验证，例子**/
    public $configArr2 = [
        'field'=>[
            'login_type'=>'CP_login_type',
            'online_time'=>'CP_online_time',
        ],
        'fieldMap'=>[
            'login_type'=>'上/下线',
            'online_time'=>'在线时间',
        ],
        'verif'=>[
            'login_type'=>[0],
        ],
        'example'=>[
            'login_type'=>1,
            'online_time'=>100,
        ],
    ];
    /*
    * 字段映射，字段说明，验证，例子**/
    public $configArr3 = [
        'field'=>[
            'type'=>'CP_type',
            'item_type'=>'CP_item_type',
            'channel'=>'CP_channel',
            'money'=>'CP_money',
            'money_type'=>'CP_money_type',
            'game_money'=>'CP_game_money',
            'order'=>'CP_order',
            'channel_order'=>'CP_channel_order',
        ],
        'fieldMap'=>[
            'type'=>'充值类型',
            'item_type'=>'道具类型',
            'channel'=>'充值渠道',
            'money'=>'货币金额',
            'money_type'=>'货币类型',
            'game_money'=>'游戏元宝类金额',
            'order'=>'cp订单号',
            'channel_order'=>'充值渠道订单号',
        ],
        'verif'=>[
            'type'=>[0],
            'channel'=>[0],
            'money'=>[0],
            'money_type'=>[''],
            'game_money'=>[0],
            'order'=>[0],
            'channel_order'=>[0]
        ],
        'example'=>[
            'type'=>'1',
            'item_type'=>'0',
            'channel'=>305,
            'money'=>1,
            'money_type'=>1,
            'game_money'=>10,
            'order'=>'ts100122',
            'channel_order'=>'qd1002',
        ],
    ];
    /*
    * 字段映射，字段说明，验证，例子**/
    public $configArr4 = [
        'field'=>[
            'type'=>'CP_type',
            'action'=>'CP_action',
            'num'=>'CP_num',
            'true_num'=>'CP_true_num',
            'false_num'=>'CP_false_num',
        ],
        'fieldMap'=>[
            'type'=>'加币类型',
            'action'=>'加币行为',
            'num'=>'加币数量',
            'true_num'=>'加通用币数量',
            'false_num'=>'加绑定币数量',
        ],
        'verif'=>[
            'type'=>[0],
            'action'=>[0],
            'num'=>[0],
        ],
        'example'=>[
            'type'=>1,
            'action'=>100,
            'num'=>200,
            'true_num'=>100,
            'false_num'=>100,
        ],
    ];
    /*
   * 字段映射，字段说明，验证，例子**/
    public $configArr5 = [
        'field'=>[
            'type'=>'CP_type',
            'object'=>'CP_object',
            'count'=>'CP_count',
            'price'=>'CP_price',
            'true_num'=>'CP_true_num',
            'false_num'=>'CP_false_num',
        ],
        'fieldMap'=>[
            'type'=>'消费类型',
            'object'=>'消费对象',
            'count'=>'消费次数',
            'price'=>'消费单价',
            'true_num'=>'消费通用币数',
            'false_num'=>'消费绑定币数',
        ],
        'verif'=>[
            'count'=>[0],
        ],
        'example'=>[
            'type'=>1,
            'object'=>2,
            'count'=>1,
            'price'=>10,
            'true_num'=>100,
            'false_num'=>100,
        ],
    ];
    /*
   * 字段映射，字段说明，验证，例子**/
    public $configArr6 = [
        'field'=>[
            'type'=>'CP_type',
            'note'=>'CP_note',
            'num'=>'CP_num',
            'true_num'=>'CP_true_num',
            'false_num'=>'CP_false_num',
        ],
        'fieldMap'=>[
            'type'=>'扣币类型',
            'note'=>'扣币说明',
            'num'=>'扣币数量',
            'true_num'=>'扣除通用币数',
            'false_num'=>'扣除绑定币数',
        ],
        'verif'=>[
            'type'=>[0],
            'num'=>[0],
        ],
        'example'=>[
            'type'=>1,
            'note'=>'活动所得',
            'num'=>200,
            'true_num'=>100,
            'false_num'=>100,
        ],
    ];
    /*
  * 字段映射，字段说明，验证，例子**/
    public $configArr7 = [
        'field'=>[
            'type'=>'CP_type',
            'action'=>'CP_action',
            'num'=>'CP_num',
        ],
        'fieldMap'=>[
            'type'=>'加币类型',
            'action'=>'加币行为',
            'num'=>'加币数量',
        ],
        'verif'=>[
            'type'=>[0],
            'action'=>[0],
            'num'=>[0],
        ],
        'example'=>[
            'type'=>2,
            'action'=>1,
            'num'=>100,
        ],
    ];
    /*
* 字段映射，字段说明，验证，例子**/
    public $configArr8 = [
        'field'=>[
            'type'=>'CP_type',
            'object'=>'CP_object',
            'count'=>'CP_count',
            'price'=>'CP_price',
        ],
        'fieldMap'=>[
            'type'=>'消费类型',
            'object'=>'消费对象',
            'count'=>'消费次数',
            'price'=>'消费单价',
        ],
        'verif'=>[
            'type'=>[0],
            'count'=>[0],
            'price'=>[0],
        ],
        'example'=>[
            'type'=>1002,
            'object'=>254,
            'count'=>1,
            'price'=>1001
        ],
    ];
    /*
* 字段映射，字段说明，验证，例子**/
    public $configArr9 = [
        'field'=>[
            'type'=>'CP_type',
            'note'=>'CP_note',
            'num'=>'CP_num',
        ],
        'fieldMap'=>[
            'type'=>'扣币类型',
            'note'=>'扣币说明',
            'num'=>'扣币数量',
        ],
        'verif'=>[
            'type'=>[0],
            'num'=>[0],
        ],
        'example'=>[
            'type'=>1002,
            'note'=>'打怪扣除',
            'num'=>1,
        ],
    ];

    /*
    * 字段
    * ***/
    public function fieldArr($behavior = 1)
    {
        $array =[
            'behavior'=>'behavior',
            'game_id'=>'game_id',
            'channel_id'=>'channel_id',
            'server_id'=>'server_id',
            'oserver_id'=>'oserver_id',
            'timestamp'=>'timestamp',
            'op_id'=>'op_id',
            'role_id'=>'role_id',

            'client_ip'=>'client_ip',
            'user_level'=>'user_level',
            'vip_level'=>'vip_level',
            'money_coin'=>'money_coin',
            'black_money'=>'black_money',
            'is_test'=>'is_test',
            'version'=>'version',
            'device'=>'device',
            'user_exp'=>'user_exp',
            'first_in_time'=>'first_in_time',
            'game_coin'=>'game_coin',
        ];
        $select = 'configArr'.$behavior;
        $data = $this->$select;
        return array_merge($array,$data['field']);
    }

    /*
     * 映射关系
     * ***/
    public function fieldMap($behavior = 1)
    {
        /*
     * 映射
     * **/
         $fieldMap = [
            'behavior'=> static::$behavior_type[$behavior],
            'game_id'=>'游戏ID',
            'channel_id'=>'渠道ID',
            'server_id'=>'服务器ID',
            'oserver_id'=>'旧服务器组ID',
            'timestamp'=>'游戏时间记录点',
            'op_id'=>'外部UID',
            'role_id'=>'角色ID',

            'client_ip'=>'用户IP',
            'user_level'=>'用户游戏等级',
            'vip_level'=>'VIP等级',
            'money_coin'=>'付费货币余额',
            'black_money'=>'付费赠送货币余额',
            'is_test'=>'用户类型',
            'version'=>'游戏版本',
            'device'=>'手机设备串号',
            'user_exp'=>'用户经验值',
            'first_in_time'=>'首次进入时间',
            'game_coin'=>'其他游戏货币余额',
        ];
        $select = 'configArr'.$behavior;
        $data = $this->$select;
        return array_merge($fieldMap,$data['fieldMap']);

    }
    /*
     * 验证
     * **/
    public function verif($behavior = 1)
    {
        $verifArr = [
            'channel_id'=>[0],
            'oserver_id'=>[0],
            'timestamp'=>[0],
            'op_id'=>[0],
//            'client_ip'=>[0],
//            'device'=>[''],
//            'is_test'=>[0],
//            'version'=>[''],
            'first_in_time'=>[0],
        ];
        $select = 'configArr'.$behavior;
        $data = $this->$select;
        return array_merge($verifArr,$data['verif']);

    }
    /*
     * 例子
     * **/
    public function example($behavior = 1)
    {
        $exampleArr = [
            'behavior'=>1,
            'game_id'=>50,
            'channel_id'=>301,
            'server_id'=>50012,
            'oserver_id'=>50012,
            'timestamp'=>1466394301,
            'op_id'=>'23045',
            'role_id'=>'5060002_96_17149',

            'client_ip'=>'192.168.1.1',
            'user_level'=>32,
            'vip_level'=>1,
            'money_coin'=>10000,
            'black_money'=>10000,
            'is_test'=>3,
            'version'=>'2.0.1',
            'device'=>'IMEI1234vfdvdc',
            'user_exp'=>'3210',
            'first_in_time'=>1466394301,
           'game_coin'=>10021,
        ];
        $select = 'configArr'.$behavior;
        $data = $this->$select;
        return array_merge($exampleArr,$data['example']);

    }



}