<?php

namespace common\models;

use Yii;
use common\libraries\base\ActiveRecord;
/**
 * This is the model class for table "module".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $perm_id
 */
class Module extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'perm_id'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'perm_id' => 'Perm ID',
        ];
    }
}
