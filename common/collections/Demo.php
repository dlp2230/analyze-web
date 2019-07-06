<?php

namespace common\collections;

use common\libraries\base\MongoActiveRecord;

class Demo extends MongoActiveRecord
{
    //sex
    const SEX_MAN = 1;
    const SEX_GIRL = 2;

    public static function collectionName()
    {
        return 'demo';
    }

    /**
     * collection包含的列名
     * @return array
     */
    public function attributes()
    {
        return ['_id', 'name', 'sex', 'age'];
    }


    /**
     * 必须填写的字段
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sex'], 'required'],

        ];
    }

}