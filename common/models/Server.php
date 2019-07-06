<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "server".
 *
 * @property string $sid
 * @property string $name
 * @property integer $game_id
 * @property integer $server_type
 */
class Server extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const SERVER_TYPE_ANDROID = 1;
    const SERVER_TYPE_IOS = 2;
    const SERVER_TYPE_ANDROID_S=3;
    const SERVER_TYPE_ANDROID_YUE=4;
    const SERVER_TYPE_ANDROID_IOS=5;


    public static $server_type =[
        self::SERVER_TYPE_ANDROID=> '安卓专服',
        self::SERVER_TYPE_IOS =>  'IOS专服',
        self::SERVER_TYPE_ANDROID_S =>    '安卓混服',
        self::SERVER_TYPE_ANDROID_YUE =>'安卓越狱混服',
        self::SERVER_TYPE_ANDROID_IOS =>'安卓IOS混服',
    ];


    public static function tableName()
    {

        return 'server';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'required'],
            [['game_id', 'server_type'], 'integer'],
            [['sid'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'name' => 'Name',
            'game_id' => 'Game ID',
            'server_type' => 'Server Type',
        ];
    }
}
