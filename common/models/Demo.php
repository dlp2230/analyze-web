<?php

namespace common\models;

use Yii;
use common\libraries\base\ActiveRecord;

/**
 * This is the model class for table "perm".
 *
 * @property string $id
 * @property string $name
 * @property string $sex
 * @property string $age
 */
class Demo extends ActiveRecord
{
    //sex
    const SEX_MAN = 1;
    const SEX_GIRL = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sex'], 'required'],
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
            'sex' => 'Sex',
            'age' => 'Age',
        ];
    }
}
