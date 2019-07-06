<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cps".
 *
 * @property integer $cps_id
 * @property integer $channel_id
 * @property string $name
 */
class Cps extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cps_id', 'channel_id'], 'required'],
            [['cps_id', 'channel_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cps_id' => 'Cps ID',
            'channel_id' => 'Channel ID',
            'name' => 'Name',
        ];
    }
}
