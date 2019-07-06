<?php
namespace backend\modules\config\controllers;

use Yii;
use backend\libraries\base\Controller;

/**
 * Setting controller
 */
class SettingController extends Controller
{
    public function actionGame()
    {
        $game_id = Yii::$app->request->get('game_id');


        return $this->renderJson(['ok' => 1, 'msg' => '切换成功!']);
    }

    public function actionDevice()
    {
        return $this->render('index');
    }
}
