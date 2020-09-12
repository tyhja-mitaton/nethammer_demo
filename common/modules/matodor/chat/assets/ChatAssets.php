<?php
namespace matodor\chat\assets;

use yii\web\AssetBundle;

class ChatAssets extends AssetBundle
{
    public $depends = [
        \yii\web\YiiAsset::class,
        \yii\web\JqueryAsset::class,
        \matodor\chat\assets\ChatNpmAssets::class,
        \matodor\chat\assets\ChatBowerAssets::class,
	];

    public $js = [
        'js/chat.js',
    ];

    public $css = [
        'css/chat.css',
    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
