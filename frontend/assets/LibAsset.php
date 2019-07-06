<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;


use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LibAsset extends AssetBundle
{
    public $sourcePath = '@front-resources';
    public $css = [
        //Bootstrap 3.3.4
         'bootstrap/css/bootstrap.min.css',
        //FontAwesome 4.3.0
        'plugins/font-awesome/css/font-awesome.min.css',
        //Ionicons 2.0.0
        'plugins/ionicons/css/ionicons.min.css',


    ];
    public $js = [
        //jQuery 2.1.4
        'plugins/jQuery/jQuery-2.1.4.min.js',
        'bootstrap/js/bootstrap.js',
        // bootbox
        'plugins/bootbox/bootbox.min.js',

        '/custom/js/utils.js',

    ];
}
