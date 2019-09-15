<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dialog.css',
        //'js/chosen/chosen.css',
        'js/select2/css/select2.css',
        'css/site.css',
    ];
    public $js = [
        'js/jquery-ui.js',
        //'js/chosen/chosen.jquery.js',
        'js/select2/js/select2.js',
        'js/options.js',
        'js/action.js',
        'js/common.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
