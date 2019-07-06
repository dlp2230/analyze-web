<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016/3/4
 * Time: 10:41
 */

namespace common\libraries\base;


class Object
{
    protected static $_singletonStack;

    /**
     * @return $this
     */
    public static function getInstance()
    {
        $class = get_called_class();
        if (empty(self::$_singletonStack[$class])) {
            self::$_singletonStack[$class] = new $class();
        }
        return self::$_singletonStack[$class];
    }

    protected function __construct()
    {

    }
}