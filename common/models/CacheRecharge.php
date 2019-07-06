<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "cache_recharge".
 *
 * @property integer $game_id
 */
class CacheRecharge extends \common\libraries\base\ActiveRecord
{
    const PAY_CP_TRUE_NUM = 1;
    const PAY_CP_FALSE_NUM = 2;
    const CONSUMPTION_CP_TRUE_NUM = 3;
    const CONSUMPTION_CP_FALSE_NUM = 4;
    const CONSUMPTION_CP_MONEY = 5;
    const PAY_CP_MONEY = 6;

    public static $recharge_config =[
        self::PAY_CP_TRUE_NUM => 'pay_cp_true_num',
        self::PAY_CP_FALSE_NUM => 'pay_cp_false_num',
        self::CONSUMPTION_CP_TRUE_NUM => 'consumption_cp_true_num',
        self::CONSUMPTION_CP_FALSE_NUM => 'consumption_cp_false_num',
        self::CONSUMPTION_CP_MONEY => 'consumption_cp_money',
        self::PAY_CP_MONEY => 'pay_cp_money',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache_recharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'channel_id','server_id','ts'], 'required'],
            [['game_id','channel_id','server_id','ts','pay_cp_false_num','consumption_cp_true_num','consumption_cp_false_num','consumption_cp_money','pay_cp_money','pay_cp_true_num'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'channel_id' => 'Channel ID',
            'server_id' => 'Server ID',
            'ts' => 'Ts',
            'pay_cp_true_num' => 'Pay Cp True Num',
            'pay_cp_false_num' => 'Pay Cp False Num',
            'consumption_cp_true_num' => 'Consumption Pay Cp True Num',
            'consumption_cp_false_num' => 'Consumption Pay Cp False Num',
            'consumption_cp_money' => 'Consumption Pay Cp Money',

        ];
    }
   /*
    * @param
    * $ts 时间
    * $game_id
    * $server_id
    * $channel_id
    * $field 字段
    * **/
    public static function getResult($ts,$game_id,$server_id,$channel_id=0,$field = '')
    {
        $where = [
            'ts'         => intval($ts),
            'game_id'   => intval($game_id),
            'server_id' => intval($server_id),
            'channel_id'=> intval($channel_id)
        ];
        $res = static::find()->where($where)->asArray()->one();
        if(!empty($res)){
            if($field){
                if($res[self::$recharge_config[$field]] != null){
                    return $res[self::$recharge_config[$field]];
                }
            }else{
                return $res;
            }
        }
        return false;

    }
    /*
     * set
     * **/
    public static function setResult($ts,$game_id,$server_id,$channel_id=0,$field,$count){
        if(time() - $ts >=86400) {
            /*
            * 当前时间-开始时间 > 1天 记录
            * **/
            $where = [
                'ts'         =>intval($ts),
                'game_id'   =>intval($game_id),
                'server_id' =>intval($server_id),
                'channel_id'=>intval($channel_id),
            ];
            $res = static::find()->where($where)->asArray()->one();
            $model = new CacheRecharge();
            $field = self::$recharge_config[$field];
            if (empty($res)) {
                // insert
                $model->ts = intval($ts);
                $model->game_id = intval($game_id);
                $model->server_id = intval($server_id);
                $model->channel_id = intval($channel_id);
                $model->$field = $count;
                $model->insert();

            } else {
                // update
                $data = $where;
                $data[$field] = $count;
                $model->updateAll($data, $where);
            }
        }
    }
}
