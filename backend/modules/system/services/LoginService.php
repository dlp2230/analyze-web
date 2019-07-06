<?php
namespace backend\modules\system\services;

use common\collections\Demo;
use common\libraries\base\Service;
use common\models\Admin;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016/3/4
 * Time: 10:56
 */
class LoginService extends Service
{
    static function login($email,$password){

        if($email && $password){
            return Admin::findOne(['email'=>$email,'password'=>md5($password)]);
        }
        else{
            return false;
        }
    }
}