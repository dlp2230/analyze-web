<?php

namespace common\models;

use Yii;
use common\libraries\base\ActiveRecord;
/**
 * This is the model class for table "perm".
 *
 * @property string $id
 * @property string $perm_id
 * @property string $name
 * @property string $pid
 */
class Perm extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'perm_id', 'name', 'pid'], 'required'],
            [['id'], 'string', 'max' => 255],
            [['perm_id', 'name', 'pid'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perm_id' => 'Perm ID',
            'name' => 'Name',
            'pid' => 'Pid',
        ];
    }
}
