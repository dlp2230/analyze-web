<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/3
 * Time: 16:31
 */

namespace backend\libraries\base;


use backend\assets\AppAsset;
use backend\assets;

class View extends \yii\web\View
{
    public $toggle = false; // 是否开启平台特定模块
    public $_menu;
    public $_activeMenu;
    public $_selectMenu;
    public $userinfo;

    public $pager;

    public $_search_data;    //用于自动填充表单


    public function pageCss($csss)
    {
        if (is_array($csss)) {
            foreach ($csss as $css) {
                $this->registerCssFile('/custom/css/' . $css, [
                    'depends' => [\backend\assets\AppAsset::className()],
                ]);
            }
        } else {
            $this->registerCssFile('/custom/css/' . $csss, [
                'depends' => [\backend\assets\AppAsset::className()],
            ]);
        }
    }

    public function pageJs($jss)
    {
        if (is_array($jss)) {
            foreach ($jss as $js) {
                $this->registerJsFile('/custom/js/' . $js, [
                    'depends' => [AppAsset::className()],
                ]);
            }
        } else {
            $this->registerJsFile('/custom/js/' . $jss, [
                'depends' => [AppAsset::className()],
            ]);
        }
    }
}