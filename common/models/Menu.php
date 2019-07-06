<?php

namespace common\models;

use Yii;
use common\libraries\base\ActiveRecord;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $menu_name
 * @property integer $pid
 * @property string $route
 * @property string $menu_perm_id
 * @property integer $sort
 * @property string $icon
 */
class Menu extends ActiveRecord
{
    public $hasFix = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_name', 'pid', 'sort'], 'required'],
            [['pid', 'is_menu', 'sort'], 'integer'],
            [['menu_name', 'menu_perm_id', 'icon'], 'string', 'max' => 40],
            [['route'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_name' => 'Menu Name',
            'pid' => 'Pid',
            'route' => 'Route',
            'menu_perm_id' => 'Menu Perm ID',
            'sort' => 'Sort',
            'icon' => 'Icon',
        ];
    }
}
