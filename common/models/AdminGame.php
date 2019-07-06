<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_game".
 *
 * @property integer $id
 * @property integer $game_id
 */
class AdminGame extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_game';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'game_id'], 'required'],
            [['id', 'game_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
        ];
    }
}
