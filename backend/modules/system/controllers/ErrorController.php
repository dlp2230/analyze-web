<?php
namespace backend\modules\system\controllers;

use Yii;
use backend\libraries\base\Controller;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Perm controller
 */
class ErrorController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actionError()
    {

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
        }
        $name = $exception->getName();
        $message = $exception->getMessage();

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('index', [
                'name' => $name,
                'message' => $message,
                'exception' => (YII_ENV == 'dev') ? $exception : '',
            ]);
        }
    }


}
