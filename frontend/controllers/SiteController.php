<?php
namespace frontend\controllers;

use yii\base\Controller;

class SiteController extends Controller
{
    public function beforeAction($action)
    {
        $this->getView()->tag = "site";
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->getView()->title = "公司介绍";
        return $this->render('index');
    }
}
