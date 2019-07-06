<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $ag_id
 * @property string $name
 * @property string $mobile
 * @property integer $status
 */
class Admin extends \common\libraries\base\ActiveRecord
{

    const STATUS_BLOCK = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'ag_id', 'name', 'mobile', 'status'], 'required'],
            [['ag_id', 'status'], 'integer'],
            [['email', 'name', 'mobile'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'ag_id' => 'Ag ID',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'status' => 'Status',
        ];
    }
}
