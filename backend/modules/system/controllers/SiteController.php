<?php
namespace backend\modules\system\controllers;

use backend\libraries\CookieAuth;
use backend\modules\system\helpers\VerificationCodeHelp;
use backend\modules\system\services\LoginService;
use common\models\Admin;
use Yii;
use backend\libraries\base\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionLogin()
    {

        Yii::$app->layout = 'login.php';

        if (!Yii::$app->request->isPost) {
            return $this->render('login');
        }
        //$admin = new Admin();
        $view['email'] = $email = Yii::$app->request->post('email');
        $view['password'] = $password = Yii::$app->request->post('password');
        $view['login_code'] = $login_code = Yii::$app->request->post('login_code');
        $view['rember'] = Yii::$app->request->post('rember');
        //$admin =new Admin();
        $session = Yii::$app->session;
        //echo ($login_code),'<br>';
        //echo $session->get('login_code');
        if ($login_code != $session->get('login_code')) {
            $view['error'] = '验证码错误';
            return $this->render('login', [
                'view' => $view,
            ]);
        }
        $admin = LoginService::getInstance()->login($email, $password);
        if (!$admin) {
            $view['error'] = '帐号或密码错误';
        } else {
            if ($admin->status != Admin::STATUS_ACTIVE) {
                $view['error'] = '该帐号已停用';
            } else {

                if ($view['rember']) {
                    $session->set('userid', $admin->id);
                    CookieAuth::getInstance()->setData(['userid' => $admin->id], 604800);
                } else {
                    $session->set('userid', $admin->id);
                    CookieAuth::getInstance()->setData(['userid' => $admin->id], 86400);
                }
                $this->redirect('/');
            }
        }


        return $this->render('login', [
            'view' => $view,
        ]);

    }

    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->remove('userid');
        CookieAuth::getInstance()->delData();
        $this->redirect('/system/site/login');
    }

    public function actionCreateCode()
    {
        VerificationCodeHelp::getInstance()->createCode(100, 34);
        Yii::$app->session->set('login_code', VerificationCodeHelp::getInstance()->getCode());
    }


}
