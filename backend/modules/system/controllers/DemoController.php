<?php
/**
 * Created by PhpStorm.
 * User: xg
 * Date: 2015/11/27
 * Time: 16:25
 */
namespace backend\modules\system\controllers;


use backend\modules\system\services\DemoService;
use common\helpers\MailHelper;
use Yii;

class DemoController extends \yii\web\Controller
{
    public function actionSendmail()
    {
        $sendArr = [
            'subject' => '你好',
            'msg' => ['content' => '2222'],
            'to' => 'xuguang@founq.com',
            //'layout'=>'layouts/text',
        ];

        MailHelper::getInstance()->send($sendArr, 'log');
        MailHelper::getInstance()->send($sendArr, 'report');
        MailHelper::getInstance()->send($sendArr);
    }

    /**
     * demo
     *
     */
    public function actionDemo()
    {
//        DemoService::getInstance()->mysqlInsertDemo();
//        DemoService::getInstance()->mysqlReadDemo();

        DemoService::getInstance()->mongoInsertDemo();
        DemoService::getInstance()->mongoReadDemo();

    }

    public function actionGetSelectMenu()
    {
        $data['game_id'] = Yii::$app->session->get('game_id');
        $data['server_type'] = Yii::$app->session->get('server_type');
        $data['server'] = Yii::$app->session->get('server');
        $data['channel'] = Yii::$app->session->get('channel');
        ee($data);
    }
}