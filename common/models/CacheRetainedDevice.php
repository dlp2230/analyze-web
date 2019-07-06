<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "game".
 *
 * @property integer $game_id
 * @property string $name
 */
class CacheRetainedDevice extends \common\libraries\base\ActiveRecord
{

    public static $retained_config =[
        2=> 'two_days_retained',
        3=> 'three_days_retained',
        4=> 'four_days_retained',
        5=> 'five_days_retained',
        6=> 'six_days_retained',
        7=> 'seven_days_retained',
        14=> 'fourteen_days_retained',
        21=> 'twentyone_days_retained',
        30=> 'thirty_days_retained',

    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache_retained_device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'channel_id','server_id','ts'], 'required'],
            [['game_id','channel_id','server_id','ts'], 'integer'],
            //[['two_days_retained','three_days_retained','four_days_retained','five_days_retained','six_days_retained','seven_days_retained','fourteen_days_retained','twentyone_days_retained','thirty_days_retained'], 'float'],

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
            'two_days_retained' => 'Two Days Retained',
            'three_days_retained' => 'Three Days Retained',
            'four_days_retained' => 'Four Days Retained',
            'five_days_retained' => 'Five Days Retained',
            'six_days_retained' => 'Six Days Retained',
            'seven_days_retained' => 'Seven Days Retained',
            'fourteen_days_retained' => 'Fourteen Days Retained',
            'twentyone_days_retained' => 'Twentyone Days Retained',
            'thirty_days_retained' => 'Thirty Days Retained',
        ];
    }
    /*
     * @param
     * **/
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public static function getDevice($ts,$game_id,$server_id,$channel_id=0,$dayNum=2)
    {
        $where = [
            'ts'=>intval($ts),
            'game_id'=>intval($game_id),
            'server_id'=>intval($server_id),
            'channel_id'=>intval($channel_id),
        ];
        $res = static::find()->where($where)->asArray()->one();
        if(!empty($res)){
            if($res[self::$retained_config[$dayNum]] != null ){
               return $res[self::$retained_config[$dayNum]];
            }
        }
        return false;

    }
    /*
     *设置留存
     * **/
    public static function setDevice($ts,$game_id,$server_id,$channel_id=0,$dayNum,$param){
        $lastDay = $ts + (86400 * $dayNum);
        /*
         *当前时间大于留存时间写入mysql
         * ***/
        if(time() >= $lastDay) {
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
            $model = new CacheRetainedDevice();
            $field = self::$retained_config[$dayNum];
            if (empty($res)) {
                // insert
                $model->ts = intval($ts);
                $model->game_id = intval($game_id);
                $model->server_id = intval($server_id);
                $model->channel_id = intval($channel_id);
                $model->$field = floatval($param);
                $model->insert();

            } else {
                // update
                $data = $where;
                $data[$field] = floatval($param);
                $model->updateAll($data, $where);
            }
        }

    }
}
