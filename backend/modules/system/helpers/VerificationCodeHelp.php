<?php
namespace backend\modules\system\helpers;

use common\libraries\base\Object;
use yii\web\Response;

class VerificationCodeHelp extends Object{

    private $code;

//  生成验证码
    function createCode($w, $h) {
        $im = imagecreate($w, $h);
//    imagecolorallocate($im, 14, 114, 180); // background color
        $red = imagecolorallocate($im, 255, 0, 0);
        $white = imagecolorallocate($im, 50, 50, 50);

        $operator = '+-*'; //运算符
        $num1 = rand(1, 9);
        $ope1 = $operator{mt_rand(0, 2)};
        $num2 = rand(1, 9);
        $ope2 = $operator{mt_rand(0, 2)};
        $num3 = rand(1, 9);

        eval("\$this->code=$num1$ope1$num2$ope2$num3;");

        $gray = imagecolorallocate($im, 118, 151, 199);
        $black = imagecolorallocate($im, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));

        //画背景
        imagefilledrectangle($im, 0, 0, $w, $h, $black);
        //在画布上随机生成大量点，起干扰作用;
        for ($i = 0; $i < 180; $i++) {
            imagesetpixel($im, rand(0, $w), rand(0, $h), $gray);
        }
        $autoHight = ceil(($h - 10) / 2);
        $autoWidth = 5;
        imagestring($im, 5, $autoWidth, $autoHight, $num1, $red);
        imagestring($im, 5, 3 * $autoWidth, $autoHight, $ope1, $red);
        imagestring($im, 5, 6 * $autoWidth, $autoHight, $num2, $red);
        imagestring($im, 5, 9 * $autoWidth, $autoHight, $ope2, $red);
        imagestring($im, 5, 12 * $autoWidth, $autoHight, $num3, $red);
        imagestring($im, 5, 13 * $autoWidth, $autoHight, " = ", $red);
        imagestring($im, 5, 18 * $autoWidth, $autoHight, '?', $white);
//        \Yii::$app->response->headers->set('Content-type','image/png');
//        header("Content-type: image/png");
        $response = \Yii::$app->response;
        $response->headers->set('Content-Type', 'image/png');
        $response->format = Response::FORMAT_RAW;
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * 获得验证码
     * @return type
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * 生成密码
     */
    function createPassword() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $len = 8;
        $strLen = strlen($chars) - 1;
        $password = '';
        for ($i = 0; $i < $len; $i++) {
            $password .= $chars[mt_rand(0, $strLen)];
        }
        return $password;
    }

}
