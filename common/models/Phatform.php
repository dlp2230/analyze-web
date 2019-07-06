<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "phatform".
 *
 * @property integer $game_id
 * @property string $private_key
 * @property integer $status
 * @property string $name
 */
class Phatform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phatform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'private_key', 'name'], 'required'],
            [['game_id', 'status'], 'integer'],
            [['private_key', 'name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'private_key' => 'Private Key',
            'status' => 'Status',
            'name' => 'Name',
        ];
    }
}
