<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;


use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LibAsset extends AssetBundle
{
    public $sourcePath = '@back-resources';
    public $css = [
        //Bootstrap 3.3.4
        // 'bootstrap/css/bootstrap.min.css',
        //FontAwesome 4.3.0
        'plugins/font-awesome/css/font-awesome.min.css',
        //Ionicons 2.0.0
        'plugins/ionicons/css/ionicons.min.css',
        //AdminLTE
        'dist/css/AdminLTE.min.css',
        //AdminLTE Skins
        'dist/css/skins/_all-skins.min.css',
        //ztree
        'plugins/ztree/css/zTreeStyle.css',

        //select2
        'plugins/select2/css/select2.min.css',
//        //iCheck
//        'plugins/iCheck/flat/blue.css',
        'plugins/iCheck/square/blue.css',

        //datetimepicker
        'plugins/datetimepicker/css/bootstrap-datetimepicker.min.css',
//        //Morris chart
//        '/plugins/morris/morris.css',
//        //jvectormap
//        '/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
//        //Date Picker
//        '/plugins/datepicker/datepicker3.css',
//        //Daterange picker
//        '/plugins/daterangepicker/daterangepicker-bs3.css',
//        //bootstrap wysihtml5 - text editor
//        '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'

    ];
    public $js = [
        //jQuery 2.1.4
        //'plugins/jQuery/jQuery-2.1.4.min.js',
        //jQuery UI 1.11.2
        //'plugins/jQueryUI/jquery-ui-1.11.2.min.js',
        //Bootstrap 3.3.2 JS  ͬ��Ϊ����ϵͳ�Դ��汾
        'bootstrap/js/bootstrap.js',
        // bootbox
        'plugins/bootbox/bootbox.min.js',
        // AdminLTE App
        'dist/js/app.min.js',
        //ztree
        'plugins/ztree/js/jquery.ztree.core-3.5.min.js',
        'plugins/ztree/js/jquery.ztree.excheck-3.5.min.js',
        //iCheck
        'plugins/iCheck/icheck.min.js',

        //select2
        'plugins/select2/js/select2.min.js',
        'plugins/select2/js/i18n/zh-CN.js',

        //datetimepicker
        'plugins/datetimepicker/js/bootstrap-datetimepicker.min.js',
        'plugins/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js',
        //-echarts
         'plugins/echarts/echarts.js',


//        //Sparkline
//        '/plugins/sparkline/jquery.sparkline.min.js',
//        //jvectormap
//        '/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
//        '/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
//        //jQuery Knob Chart
//        '/plugins/knob/jquery.knob.js',
//        //daterangepicker
//        '/plugins/moment/moment.min.js',
//        '/plugins/moment/moment.min.js',
//        '/plugins/daterangepicker/daterangepicker.js',
//        //datepicker
//        '/plugins/datepicker/bootstrap-datepicker.js',
//        //Bootstrap WYSIHTML5
//        '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
//        //FastClick
//        '/plugins/fastclick/fastclick.min.js',
//        //Slimscroll
//        '/plugins/slimScroll/jquery.slimscroll.min.js',
//        Utils


        '/custom/js/utils.js',
    ];
}
