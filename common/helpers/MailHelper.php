<?php

namespace common\helpers;
use common\libraries\base\Object;
use yii;

class MailHelper  extends Object{


    public function init(){

    }



    /**
     * @param $sendArr      包含需要发送的信息格式：['subject'=>'你好',
     * 'msg'=>['content'=>'2222'],'to'=>'xuguang@founq.com','layout'=>'layouts/text'] 前3个必填
     * @param  $transport  发送人信息配置参数里面配置    false使用默认发送人配置  常用值 log
     * @return bool
     */
    public function send($sendArr,$transport=false){
        Yii::$app->mailer->setTransport($transport);
        if(empty($sendArr['layout'])){
            $sendArr['layout'] = 'layouts/text';
        }

        $username = yii::$app->mailer->getTransport()->getUsername();
        if(is_array($username)){
            $usernameArr = $username;
            Yii::$app->mailer->getTransport()->setUsername(key($usernameArr));
        }
        else{
            $usernameArr = [$username=>$username];
        }

        return
            Yii::$app->mailer->compose($sendArr['layout'],$sendArr['msg'])
            ->setFrom($usernameArr)
            ->setTo($sendArr['to'])
            ->setSubject($sendArr['subject'])->send();

    }



}