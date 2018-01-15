<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '/backend/web';
    public $css = [
        'css/style.css',
        'material/css/icons/icomoon/styles.css',
        'material/css/bootstrap.min.css',
        'material/css/core.css',
        'material/css/components.css',
        'material/css/colors.css',
    ];
    public $js = [
        'material/js/plugins/loaders/pace.min.js',
        'material/js/core/libraries/bootstrap.min.js',
        'material/js/plugins/loaders/blockui.min.js',

        'material/js/core/app.js',
        'material/js/plugins/ui/ripple.min.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
