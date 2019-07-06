<?php

namespace common\models;

use common\libraries\base\ActiveRecord;
use Yii;

/**
 * This is the model class for table "admin_group_perm".
 *
 * @property integer $id
 * @property integer $ag_id
 * @property string $perm_id
 */
class AdminGroupPerm extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_group_perm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ag_id'], 'integer'],
            [['perm_id'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ag_id' => 'Ag ID',
            'perm_id' => 'Perm ID',
        ];
    }
}
