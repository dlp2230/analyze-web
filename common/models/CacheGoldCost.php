<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "cache_money_cost".
 *
 * @property integer $game_id
 */
class CacheGoldCost extends \common\libraries\base\ActiveRecord
{
    const CP_TYPE = 1;
    const COUNT = 2;
    public static $config_arr =[
        self::CP_TYPE => 'CP_type',
        self::COUNT =>'count',

    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache_gold_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'channel_id','server_id','ts','CP_type'], 'required'],
            [['game_id','channel_id','server_id','ts','CP_type','count'], 'integer'],
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
            'gold_consumption' => 'Gold Consumption',
            'CP_type' => 'CP Type',
            'count' => 'Count',
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
    public static function getResult($ts,$game_id,$server_id,$channel_id=0,$desc = 'count')
    {
        $where = [
            'ts'         => intval($ts),
            'game_id'   => intval($game_id),
            'server_id' => intval($server_id),
            'channel_id'=> intval($channel_id)
        ];
        $res = static::find()->where($where)->orderBy($desc.' desc')->asArray()->all();
        if(!empty($res))
            return $res;
        return false;

    }
    /*
     * set
     * **/
    public static function setResult($ts,$game_id,$server_id,$channel_id=0,$cp_type,$count){
        if(time() - $ts >=86400) {
            /*
            * 当前时间-开始时间 > 1天 记录
            * **/
            $where = [
                'ts'         =>intval($ts),
                'game_id'   =>intval($game_id),
                'server_id' =>intval($server_id),
                'channel_id'=>intval($channel_id),
                'CP_type'=>$cp_type,
            ];
            $res = static::find()->where($where)->asArray()->one();
            $model = new CacheGoldCost();
            $field = self::$config_arr[self::COUNT];
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
