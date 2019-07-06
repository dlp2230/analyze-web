<?php

namespace common\models;

use common\libraries\base\ActiveRecord;
use Yii;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $ag_id
 * @property string $name
 * @property string $description
 * @property integer $type
 */
class AdminGroup extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type'], 'required'],
            [['description'], 'string'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ag_id' => 'Ag ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
        ];
    }
}
