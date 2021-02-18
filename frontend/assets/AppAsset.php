<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/styles.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/jquery.fancybox.css',
    ];
    //public $cssOptions = ['position' => \yii\web\View::POS_END];

    public $js = [
        'js/owl.carousel.min.js',//owl.carousel.js - старый файл (нет багов в отображении, но автопрокрутка не работает)
        'js/jquery.fancybox.js',
        'js/scripts.js',
    ];

    public $depends = [
        \common\assets\CommonAssets::class
    ];
}
