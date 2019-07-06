<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "server_channel".
 *
 * @property string $sid
 * @property integer $channel_id
 */
class ServerChannel extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'server_channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'required'],
            [['channel_id'], 'integer'],
            [['sid'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'channel_id' => 'Channel ID',
        ];
    }
}
