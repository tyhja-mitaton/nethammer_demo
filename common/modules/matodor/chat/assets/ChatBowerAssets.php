<?php
namespace matodor\chat\assets;

use yii\web\AssetBundle;

class ChatBowerAssets extends AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery-easing-original/jquery.easing.min.js',
        'jquery-tmpl/jquery.tmpl.min.js'
    ];

    public function init()
    {
        parent::init();
    }
}