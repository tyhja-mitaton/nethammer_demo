<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SlickSliderAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/slick/slick-theme.css',
        'css/slick/slick.css',
    ];

    public $js = [
        'js/slick.min.js',
    ];

    public $depends = [
        \yii\web\JqueryAsset::class,
    ];
}
