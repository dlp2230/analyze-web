<?php
namespace backend\libraries\base;

use backend\helpers\SelectMenuHelper;
use backend\libraries\CookieAuth;
use backend\libraries\Permission;
use backend\libraries\SimplePager;
use backend\helpers\Tool;
use common\models\Admin;
use yii;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/2
 * Time: 10:46
 */
class Controller extends \yii\web\Controller
{

    //public $enableCsrfValidation = false;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        //登录表格不检测重复提交,否则需要提供 _csrf
        $this->enableCsrfValidation = false;


        parent::beforeAction($action);
        return $this->checkPerm();
    }

    /*
 * 快速填充检索表单 用于检索菜单
 */

    protected function quickFillForm()
    {

        $data = [];
        foreach ($_REQUEST as $k => $v) {
            $data[$k] = $v;
        }
        Yii::$app->getView()->_search_data = json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function checkPerm()
    {
        //step1 页面是否需要登录
        $m = strtolower(str_replace('-', '', $this->module->id));
        $c = strtolower(str_replace('-', '', $this->id));
        $a = strtolower(str_replace('-', '', $this->action->id));
        $mca = '/' . $m . '/' . $c . '/' . $a;
        if (in_array($mca, Yii::$app->params['noNeedLogin'])) {
            return true;
        }

        $session = Yii::$app->session;
        if ($session->has('userid')) {
            $userid = $session->get('userid');
        } else if (isset($_COOKIE[CookieAuth::getInstance()->getCookieKey()])) {
            $userid = CookieAuth::getInstance()->getData('userid');
            $session->set('userid', $userid);
        } else {
            $this->redirect('/system/site/login');
        }

        if (!is_int($userid) || $userid == 0) {
            $this->redirect('/system/site/logout');
        }

        $ag_id = Admin::findOne(['id' => $userid])->ag_id;

        $session->set('ag_id', $ag_id);
        //step3 权限模块身份验证
        Permission::getInstance()->init($userid);
        //step4 是否有当前页面权限
        if (!Permission::getInstance()->checkPerm(['m' => $m, 'c' => $c, 'a' => $a])) {
            //TODO backjs
            if (Yii::$app->request->isAjax) {
                //echo $this->renderJson(['ok' => 0, 'msg' => '权限不足!', 'code' => 1]);
                echo '权限不足!';
                exit;
            } else {
                Tool::backJs('权限不足!');
            }
        }
        //step5 创建菜单
        $menu = Permission::getInstance()->createMenu();
        Yii::$app->view->_menu = $menu['menu'];
        Yii::$app->view->_activeMenu = $menu['activeMenu'];
        Yii::$app->view->userinfo = Admin::findOne($userid);
        //页面板式切换
        if (in_array($m, Yii::$app->params['gscLayoutModule'])) {
            Yii::$app->view->toggle = 'gsc';
            SelectMenuHelper::getInstance()->createGscSelectMenu($userid);
        } elseif (in_array($m, Yii::$app->params['gcLayoutModule'])) {
            Yii::$app->view->toggle = 'gc';
            SelectMenuHelper::getInstance()->createGcSelectMenu($userid);
        }
        return true;
    }

    /*
     * 快速生成分页数据和下标
     * parms:  $Model:实现检索方法的模型名称
     * 		   $Function:统计数据
     * 		   //需要衍生实现total.$Function方法统计总数
     * 		   $prams:where参数 array('key ='=>string,
     * 								 'key in'=> array());
     * 					 k对应数据库字段名附加上操作符 value部分为数组或字符串
     * 		   $config:分页参数 array($disNums每页数目,$link分页链接)
     *  */
    protected function quickDataAndPage($Model, $Function, $config, $parms = array())
    {
        $pager = new SimplePager($config['disNums']);
        //过滤数组中的false值(空和0),page值
        $parms = array_filter($parms, function ($v) {
            if ($v === '' || $v === NULL) {
                return false;
            }
            return true;
        });
        $whereStr = '';
        if (!empty($parms)) {//过滤掉其中为空的信息 防止sql报错
            //创建where语句
            foreach ($parms as $k => $v) {
                if (is_array($v)) {
                    $where[] = $k . "('" . implode("','", $v) . "')";
                } else {
                    $where[] = $k . "'$v'";
                }
            }

            $whereStr = implode(' AND ', $where);
        }

        //pe($whereStr);
        //数据查询
        $data = $Model::getInstance()->$Function($pager->start, $pager->perpage, $whereStr);

        //总数查询
        $totalFunction = $Function . 'Count';
        $total = $Model::getInstance()->$totalFunction($whereStr);

        $pager->setTotal($total);
        //如果查询的数据为空，则设为空数组
        $data = !empty($data) ? $data : array();
        Yii::$app->view->pager = $pager;
        return $data;
    }

    /*
    * 快速生成mongodb分页数据和下标
    * parms:  $Model:实现检索方法的模型名称
    * 		   $Function:统计数据
    * 		   //需要衍生实现total.$Function方法统计总数
    * 		   $prams:where参数 array('key ='=>string,
    * 								 'key in'=> array());
    * 					 k对应数据库字段名附加上操作符 value部分为数组或字符串
    * 		   $config:分页参数 array($disNums每页数目,$link分页链接)
    *  */
    protected function quickMongoDataAndPage($Model, $Function, $config, $parms = array())
    {
        $pager = new SimplePager($config['disNums']);
        //过滤数组中的false值(空和0),page值
        $parms = array_filter($parms, function ($v) {
            if ($v === '' || $v === NULL) {
                return false;
            }
            return true;
        });
        //pe($whereStr);
        //数据查询
        $data = $Model::getInstance()->$Function($pager->start, $pager->perpage, $parms);

        //总数查询
        $totalFunction = $Function . 'Count';
        $total = $Model::getInstance()->$totalFunction($parms);

        $pager->setTotal($total);
        //如果查询的数据为空，则设为空数组
        $data = !empty($data) ? $data : array();
        Yii::$app->view->pager = $pager;
        return $data;
    }

    /**
     * @param array $params [ok=>0：失败，1：成功，receipt=> 1:开启回执，msg=>提示信息]
     * @return string
     */
    public function renderJson($params = [])
    {
        header('Content-Type: application/json; charset=utf-8');
        $jsonStr = json_encode($params, JSON_UNESCAPED_UNICODE);
        return $jsonStr;
    }

    public function getViewPath()
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', parent::getViewPath()))));
    }

    public function redirect($url, $statusCode = 302)
    {
        parent::redirect($url, $statusCode);
        Yii::$app->response->send();
    }
}