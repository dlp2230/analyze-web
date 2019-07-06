<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property integer $game_id
 * @property string $name
 */
class Game extends \common\libraries\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id'], 'required'],
            [['game_id'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'name' => 'Name',
        ];
    }
}
