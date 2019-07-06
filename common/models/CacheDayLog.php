<?php

namespace common\models;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "cache_day_log".
 *
 * @property integer $game_id
 * @property string $name
 */
class CacheDayLog extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const REGISTER_ROLE_NUM = 1;
    const REGISTER_DEVICE_NUM = 2;
    const ACTIVE_ROLE_NUM = 3;
    const ACTIVE_GAME_NUM = 4;
    const ACTIVE_GAME_TIME = 5;
    const SEVEN_DAY_LOSS = 6;
    const FOURTEEN_DAY_LOSS = 7;
    const THIRTY_DAY_LOSS = 8;
    const SEVEN_DAY_ACTIVE = 9;
    const FOURTEEN_DAY_ACTIVE = 10;
    const THIRTY_DAY_ACTIVE = 11;
    const SEVEN_DAY_CONTRIBUTION = 12;
    const FOURTEEN_DAY_CONTRIBUTION = 13;
    const THIRTY_DAY_CONTRIBUTION = 14;
    const PAY_NUMS = 15;
    const PAY_TOTAL = 16;
    const ONE_TO_TEN = 17;
    const ELEVEN_TO_ONEHUNDRED = 18;
    const HUNDREDONE_TO_FIVEHUNDRED = 19;
    const FIVEHUNDRED_TO_ONETHOUSAND = 20;
    const ONETHOUSAND_ABOVE = 21;
    public static $day_login_config =[
        self::REGISTER_ROLE_NUM     =>'register_role_num',
        self::REGISTER_DEVICE_NUM  =>'register_device_num',
        self::ACTIVE_ROLE_NUM      =>'active_role_num',
        self::ACTIVE_GAME_NUM      =>'active_game_num',
        self::ACTIVE_GAME_TIME     =>'active_game_time',
        self::SEVEN_DAY_LOSS       =>'seven_day_loss',
        self::FOURTEEN_DAY_LOSS   =>'fourteen_day_loss',
        self::THIRTY_DAY_LOSS     =>'thirty_day_loss',
        self::SEVEN_DAY_ACTIVE     =>'seven_day_active',
        self::FOURTEEN_DAY_ACTIVE     =>'fourteen_day_active',
        self::THIRTY_DAY_ACTIVE     =>'thirty_day_active',
        self::SEVEN_DAY_CONTRIBUTION     =>'seven_day_contribution',
        self::FOURTEEN_DAY_CONTRIBUTION     =>'fourteen_day_contribution',
        self::THIRTY_DAY_CONTRIBUTION     =>'thirty_day_contribution',
        self::PAY_NUMS     =>'pay_nums',
        self::PAY_TOTAL     =>'pay_total',
        self::ONE_TO_TEN    =>'one_to_ten',
        self::ELEVEN_TO_ONEHUNDRED     =>'eleven_to_onehundred',
        self::HUNDREDONE_TO_FIVEHUNDRED     =>'hundredone_to_fivehundred',
        self::FIVEHUNDRED_TO_ONETHOUSAND     =>'fivehundred_to_onethousand',
        self::ONETHOUSAND_ABOVE     =>'onethousand_above',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache_day_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'channel_id','server_id','ts'], 'required'],
            [['game_id','channel_id','server_id','ts','register_role_num','register_device_num','active_role_num','active_game_num','active_game_time','seven_day_loss','fourteen_day_loss','thirty_day_loss','seven_day_active','fourteen_day_active','thirty_day_active','seven_day_contribution','fourteen_day_contribution','thirty_day_contribution','pay_nums','pay_total','one_to_ten','eleven_to_onehundred','hundredone_to_fivehundred','fivehundred_to_onethousand','onethousand_above'], 'integer'],
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
            'register_role_num' => 'Register Role Num',
            'register_device_num' => 'Register Device Num',
            'active_role_num' => 'Active Role Num',
            'active_game_num' => 'Active Game Num',
            'active_game_time' => 'Active Game Time',
            'seven_day_loss' => 'Seven Day Loss',
            'fourteen_day_loss' => 'Fourteen Day Loss',
            'thirty_day_loss' => 'Thirty Day Loss',
            'seven_day_active' => 'Seven Day Active',
            'fourteen_day_active' => 'Fourteen Day Active',
            'thirty_day_active' => 'Thirty Day Active',
            'seven_day_contribution' => 'Seven Day Contribution',
            'fourteen_day_contribution' => 'Fourteen Day Contribution',
            'thirty_day_contribution' => 'Thirty Day Contribution',
            'pay_nums' => 'Pay Nums',
            'pay_total'=>'Pay Total',
            'one_to_ten'=>'One To Ten',
            'eleven_to_onehundred'=>'Eleven To Onehundred',
            'hundredone_to_fivehundred'=>'Hundredone To Fivehundred',
            'fivehundred_to_onethousand'=>'Fivehundred To Onethousand',
            'onethousand_above'=>'Onethousand Above',
        ];
    }
    /*
     * @param
     * **/
    public static function getResultOne($ts,$game_id,$server_id,$channel_id=0,$field = '')
    {
        $where = [
            'ts'         =>intval($ts),
            'game_id'   =>intval($game_id),
            'server_id' =>intval($server_id),
            'channel_id'=>intval($channel_id),
        ];
        $res = static::find()->where($where)->asArray()->one();
        if(!empty($res)){
            if($field){
                if($res[self::$day_login_config[$field]] != null){
                    return $res[self::$day_login_config[$field]];
                }
            }else{
                return $res;
            }
        }
        return false;
    }
    /*
     *写入数据
     * phpstorm 2016-06-01 pm dlx
     * **/
    public static function setResult($ts,$game_id,$server_id,$channel_id=0,$nums,$count){

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
            $model = new CacheDayLog();
            $field = self::$day_login_config[$nums];
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
