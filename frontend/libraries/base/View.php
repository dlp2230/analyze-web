<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/3
 * Time: 16:31
 */

namespace frontend\libraries\base;

class View extends \yii\web\View
{
    public $pager;
    public $tag;

    public function pageCss($csss)
    {
        if (is_array($csss)) {
            foreach ($csss as $css) {
                $this->registerCssFile('/custom/css/'.$css, [
                    'depends' => [\frontend\assets\AppAsset::className()],
                ]);
            }
        } else {
            $this->registerCssFile('/custom/css/'.$csss, [
                'depends' => [\frontend\assets\AppAsset::className()],
            ]);
        }
    }

    public function pageJs($jss)
    {
        if (is_array($jss)) {
            foreach ($jss as $js) {
                $this->registerJsFile('/custom/js/'.$js, [
                    'depends' => [\frontend\assets\AppAsset::className()],
                ]);
            }
        } else {
            $this->registerJsFile('/custom/js/'.$jss, [
                'depends' => [\frontend\assets\AppAsset::className()],
            ]);
        }
    }
}