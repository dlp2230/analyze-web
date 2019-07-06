<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cache_channel_day_log".
 *
 * @property integer $ts
 * @property integer $game_id
 * @property integer $server_id
 * @property integer $channel_id
 * @property integer $new_role
 * @property integer $new_device
 * @property integer $pay_man
 * @property integer $pay_sum
 */
class CacheChannelDayLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache_channel_day_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ts', 'game_id', 'server_id', 'channel_id'], 'required'],
            [['ts', 'game_id', 'server_id', 'channel_id', 'new_role', 'new_device', 'pay_man', 'CP_money'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ts' => 'Ts',
            'game_id' => 'Game ID',
            'server_id' => 'Server ID',
            'channel_id' => 'Channel ID',
            'new_role' => 'New Role',
            'new_device' => 'New Device',
            'pay_man' => 'Pay Man',
            'CP_money' => 'Pay Sum',
        ];
    }

    const NEW_ROLE = 'new_role';
    const NEW_DEVICE = 'new_device';
    const PAY_MAN = 'pay_man';
    const CP_MONEY = 'CP_money';

    static function countRole($game_id,$channel_id,$start_time,$type){
        $where=[
            'game_id' => $game_id,
            'channel_id' => $channel_id,
            'ts'=>$start_time
        ];
        $res =self::find()->select(['server_id',$type])->where($where)->orderBy('server_id')->asArray()->all();
        if(!empty($res)&&$res){
            return $res;
        }else{
            return false;
        }
    }

    static function setRoleResult($result,$game_id,$channel_id,$time,$type){
        $where=[
            'game_id' => intval($game_id),
            'channel_id' => intval($channel_id),
            'ts'=>intval($time),
        ];
        if($time+86400 < time()){
            foreach ($result as $key => $value) {
                $where['server_id']=intval($value['server_id']);
                $res =self::findOne($where);
                if(empty($res)){
                    $list=new CacheChannelDayLog;
                    $list['ts'] = intval($time);
                    $list['game_id'] =  intval($game_id);
                    $list['channel_id'] =  intval($channel_id);
                    $list['server_id'] =  intval($value['server_id']);
                    $list[$type] =  intval($value[$type]);
                    $list->insert();
                }else{
                    $res[$type]=intval($value[$type]);
                    $res->update();
                }
            }
            return true;
        }else{
            return false;
        }
    }
}
