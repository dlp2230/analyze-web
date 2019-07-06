<?php

namespace common\collections;

use common\libraries\base\MongoActiveRecord;

class Log extends MongoActiveRecord
{
    //behavior
    const REGISTER = 1;
    const LOGIN = 2;
    const PAY = 3;
    const MONEY_ADD = 4;
    const MONEY_COST = 5;
    const MONEY_MINUS = 6;
    const GOLD_ADD = 7;
    const GOLD_COST = 8;
    const GOLD_MINUS = 9;

    public static function collectionName()
    {
        return 'log';
    }

    public function attributes()
    {
        return ['_id', 'behavior', 'game_id', 'channel_id', 'server_id', 'oserver_id', 'timestamp', 'op_id', 'role_id',
            'client_ip', 'user_level', 'vip_level', 'money_coin', 'black_money', 'is_test', 'version', 'device', 'user_exp', 'first_in_time', 'game_coin'];
    }

    protected static function transformRules()
    {
        return [
            '_id' => 'string',
            'behavior' => 'int',
            'game_id' => 'int',
            'channel_id' => 'int',
            'server_id' => 'int',
            'oserver_id' => 'int',
            'timestamp' => 'int',
            'op_id' => 'string',
            'role_id' => 'string',
            'client_ip' => 'string',
            'user_level' => 'int',
            'vip_level' => 'int',
            'money_coin' => 'int',
            'black_money' => 'int',
            'is_test' => 'int',
            'version' => 'string',
            'device' => 'string',
            'user_exp' => 'int',
            'first_in_time' => 'int',
            'game_coin' => 'int',
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['behavior', 'game_id', 'channel_id', 'server_id', 'oserver_id', 'timestamp', 'op_id', 'role_id'], 'required'],
        ];
    }
}