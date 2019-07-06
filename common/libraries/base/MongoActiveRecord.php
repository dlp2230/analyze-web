<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/2
 * Time: 10:58
 */

namespace common\libraries\base;


class MongoActiveRecord extends \yii\mongodb\ActiveRecord
{
    /**
     * @var array
     * 支持类型 int string
     */
    protected static function transformRules()
    {
        return [
        //    'game_id' => '1',
        ];
    }

    /**
     * 根据默认规则对数组进行格式转换
     * @param $data
     * @return mixed
     */
    public static function transArr($data)
    {
        foreach ($data as $k => &$v) {
            $v = static::transKey($k, $v);
        }
        return $data;
    }

    /**
     * 根据$key的格式对$value进行格式转换
     * @param $key
     * @param $value
     * return $value
     */
    public static function transKey($key, $value)
    {
        $trans = static::transformRules()[$key];
        eval("\$value =($trans)'$value';");
        return $value;
    }

    /**
     * 根据$key的格式批量对$valueArray进行格式转换
     * @param $key
     * @param $valueArray
     * @return mixed
     */
    public static function transArrWithKey($key, $valueArray)
    {
        foreach($valueArray as &$v){
            $v = self::transKey($key,$v);
        }
        return $valueArray;
    }




}