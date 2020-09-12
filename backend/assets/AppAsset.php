<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css',
    ];

    public $depends = [
        \common\assets\CommonAssets::class,
        \dmstr\web\AdminLteAsset::class,
    ];

    public function init()
    {
        parent::init();

        Yii::$app->view->on(View::EVENT_BEFORE_RENDER, function () {
            if (array_key_exists('dmstr\web\AdminLteAsset', Yii::$app->view->assetBundles)) {
                Yii::$app->view->assetBundles['dmstr\web\AdminLteAsset']->js = ['js/adminlte.min.js'];
            }
        });
    }
}
