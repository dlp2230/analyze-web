<?php

namespace common\models;

use Yii;
use common\libraries\base\ActiveRecord;
/**
 * This is the model class for table "perm_group".
 *
 * @property string $id
 * @property string $name
 * @property string $pid
 * @property string $perm_id
 */
class PermGroup extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perm_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'pid'], 'required'],
            [['id', 'pid', 'perm_id'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 20]
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
            'pid' => 'Pid',
            'perm_id' => 'Perm_ID',
        ];
    }
}
