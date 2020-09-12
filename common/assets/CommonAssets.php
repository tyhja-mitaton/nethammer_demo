<?php
namespace common\assets;

use yii\web\AssetBundle;

class CommonAssets extends AssetBundle
{
    public $css = [
        'css/font-awesome.css',
    ];

    public $js = [
// 'js/common.js',
    ];

    public $depends = [
        \yii\web\YiiAsset::class,
        \yii\bootstrap4\BootstrapAsset::class,
        \yii\bootstrap4\BootstrapPluginAsset::class,
    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];

    public function init()
    {
        parent::init();

        $this->sourcePath = __DIR__ . '/../web';
    }
}
