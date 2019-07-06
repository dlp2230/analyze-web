<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 2016/5/12
 * Time: 14:27
 */

namespace backend\helpers;

use common\libraries\base\Object;

class Tool extends Object
{
    static function backJs($msg)
    {
        echo "<script>alert('{$msg}');history.back();</script>";
        exit;
    }


    static function redirectJs($msg, $url)
    {
        echo "<script>alert('{$msg}');window.location.href='" . $url . "'</script>";
        exit;
    }
    /*
     * 生成随机字符串
     * **/
    static function spRandomString($len = 6) {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        //shuffle($chars);    // 将数组打乱
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }
    /*Date
    **按天分组  dlx
    */
    static function getDateLists($start_time, $end_time) {
        $start = date('Y-m-d', $start_time);
        $end = date('Y-m-d', $end_time);
        $dates = array();
        for ($i = strtotime($start); $i <= strtotime($end); $i += 86400) {
            $dates[] = date('Y-m-d', $i);
        }
        return $dates;
    }
    /*
     *过滤时间
     * ***/
    static function filterTime($ts){
        if(empty($ts) || $ts>time()){
            $ts = time();
        }
        return $ts;
    }

}