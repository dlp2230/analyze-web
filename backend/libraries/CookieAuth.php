<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/5
 * Time: 18:14
 */

namespace backend\libraries;
use common\libraries\base\Object;

class CookieAuth extends Object
{
    protected static $instance;
    protected static $cookieKey = 'FOUNQ_B';
    protected static $mcryptKey = "3b0e2a3255c8cf6331f4330113cb6192";
    protected static $authInfo;
    protected static $iv;

//    public static function getInstance() {
//        if (!self::$instance) {
//            self::$instance = new self();
//        }
//        return self::$instance;
//    }

    public function getCookieKey(){
        return self::$cookieKey;
    }

    protected function __construct() {
        if (!empty($_COOKIE[self::$cookieKey])) {
            $plain = base64_decode($_COOKIE[self::$cookieKey]);
            $key = pack('H*', self::$mcryptKey);
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $iv = str_pad("\0", $iv_size, "\0");
            self::$authInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $plain, MCRYPT_MODE_CBC, $iv);

            self::$authInfo = json_decode(rtrim(self::$authInfo, "\0"), true);
        }
    }

    public function setData(array $data, $time = 604800, $domain = '') {
        $plain = json_encode($data);
        $key = pack('H*', self::$mcryptKey);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = str_pad("\0", $iv_size, "\0");

        $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plain, MCRYPT_MODE_CBC, $iv);

        setcookie(self::$cookieKey, base64_encode($encrypt), time() + $time, '/', $domain);
    }

    public function delData($domain =''){
        setcookie(self::$cookieKey, '', time() -100, '/', $domain);
    }

    public function getData($item = '', $default = null) {
        if ($item) {
            return isset(self::$authInfo[$item]) ? self::$authInfo[$item] : $default;
        } else {
            return self::$authInfo;
        }
    }
}