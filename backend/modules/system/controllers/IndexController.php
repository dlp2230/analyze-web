<?php
namespace backend\modules\system\controllers;

use Yii;
use backend\libraries\base\Controller;

/**
 * Index controller
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
