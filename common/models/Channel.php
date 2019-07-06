<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $channel_id
 * @property string $name
 * @property integer $type
 */
class Channel extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */

    const ANDROID = 1;
    const IOS =2;
    const IOS_YUE=3;

    static $device_type = [
        self::ANDROID => '安卓',
        self::IOS =>'IOS',
        self::IOS_YUE =>'IOS越狱',
    ];


    public static function tableName()
    {
        return 'channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id'], 'required'],
            [['channel_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'channel_id' => 'Channel ID',
            'name' => 'Name',
            'type' => 'Type',
        ];
    }
    /*
     * 返回渠道 2016-04-27 pm dlx
     * **/
    public static function getChannelName($find='')
    {
        $info = [];
        $result = static::find()->asArray()->all();
        if(!empty($result)){
            foreach($result as $item){
                $info[$item['channel_id']] = $item['name'];
            }
            if($find){
                return $info[$find];
            }
        }
        return $info;

    }
}
