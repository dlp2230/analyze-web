<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 14:27
 */

namespace backend\helpers;
use common\collections\log\MoneyAddLog;
use common\collections\log\RegisterLog;
use common\collections\log\LoginLog;
use common\collections\log\PayLog;
use common\collections\log\MoneyCostLog;
use common\collections\log\MoneyMinusLog;
use common\collections\log\GoldCostLog;
use common\libraries\base\Object;

class DataTest extends Object
{
    public static $config_arr = [
        1,2,3,4,5,6,8
    ];
    /*
     * Param $model
     * **/
    static function DataTestInsert($game_id=1,$behavior=1)
    {
        $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
        $CP_create_time = rand(strtotime($BeginDate),time());
        switch($behavior){
            case 1:
                $model = RegisterLog::getCollection();
                $data['CP_channel_id'] = 101;
                $data['CP_role_id']  = '7';
                $data['CP_create_time']  = $CP_create_time;
                break;
            case 2:
                $model = LoginLog::getCollection();
                $data['CP_login_type'] = rand(1,2);
                $data['CP_online_time'] = rand(100,999);
                break;
            case 3:
                $model = PayLog::getCollection();
                $data['CP_type'] = rand(1,2);
                $data['CP_item_type'] = rand(1,999);
                $data['CP_channel'] = rand(1,2);
                $data['CP_money'] = (float) rand(10,300);
                $data['CP_money_type'] = 'CNY';
                $data['CP_game_money'] = rand(10,100);
                $data['CP_order'] = 'ts'.time();
                $data['CP_channel_order'] = 'ts'.time();
               break;
            case 4:
                $model = MoneyAddLog::getCollection();
                $data['CP_type'] = rand(1,4);
                $data['CP_action'] = rand(0,2);
                $data['CP_num'] = rand(5,100);
                $data['CP_true_num']  = rand(5,100);
                $data['CP_false_num'] = rand(100,300);
                break;
            case 5:
                $model = MoneyCostLog::getCollection();
                $data['CP_type'] = rand(1,2);
                $data['CP_object'] = rand(1,999);
                $data['CP_count'] = rand(1,2);
                $data['CP_price'] = rand(10,300);
                $data['CP_true_num'] = rand(10,100);
                $data['CP_false_num'] = rand(10,100);
                break;
            case 6:
                $model = MoneyMinusLog::getCollection();
                $data['CP_type'] = rand(1,2);
                $data['CP_note'] = '1';
                $data['CP_num'] = rand(5,100);
                $data['CP_true_num']  = rand(5,100);
                $data['CP_false_num'] = rand(100,300);
                break;
            case 8:
                $model = MoneyCostLog::getCollection();
                $data['CP_type'] = rand(1,2);
                $data['CP_object'] = rand(1,999);
                $data['CP_count'] = rand(1,2);
                $data['CP_price'] = rand(10,300);
                break;
            default:
                break;

        }

            $role_id = (string) rand(1,20);
            $device = Tool::spRandomString(6);
            $timestamp = rand(strtotime($BeginDate),time());
            $first_in_time = time();

            $data['behavior'] = $behavior;
            $data['game_id']  = $game_id;
            $data['channel_id'] = 100;
            $data['server_id'] = 2;
            $data['oserver_id'] = 1002;
            $data['oserver_id'] = 1003;
            $data['timestamp'] =$timestamp;
            $data['op_id'] = '1002';
            $data['role_id'] = $role_id;
            $data['client_ip'] = '127.0.0.1';
            $data['user_level'] = 32;
            $data['vip_level'] = 1;
            $data['money_coin'] = 520;
            $data['black_money'] = 12;
            $data['is_test'] = 1;
            $data['version'] = '1.0';
            $data['device'] = $device;
            $data['user_exp'] = 500;
            $data['first_in_time'] = $first_in_time;
            $data['game_coin'] = 32;
            $model->insert($data);

    }
    /*
     * 批量写入
     * **/
    public static function batchInsert($game_id){
        $res = self::$config_arr;
        foreach($res as $item){
            self::DataTestInsert($game_id,$item);
        }
        exit('插入成功!');

    }
}