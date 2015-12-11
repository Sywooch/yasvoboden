<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = [ 'position' => \yii\web\View::POS_HEAD ];
    public $css = [
        'css/admin.css',
         'lib/bootstrap/css/bootstrap.min.css',
    ];
    public $js = [
        'js/admin_index.js',
        'lib/bootstrap/js/bootstrap.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset', 
    ];
}
