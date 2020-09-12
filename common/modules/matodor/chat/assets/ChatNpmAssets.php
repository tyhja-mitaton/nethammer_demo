<?php
namespace matodor\chat\assets;

use yii\web\AssetBundle;

class ChatNpmAssets extends AssetBundle
{
    public $sourcePath = '@npm';

    public $js = [
        'form-serializer/dist/jquery.serialize-object.min.js',
        'tinysort/dist/tinysort.min.js',
        'tinysort/dist/jquery.tinysort.min.js',
        'moment/min/moment.min.js',
        'moment/locale/es-us.js',
        'moment/locale/ru.js',
        'moment/locale/de.js',
    ];

    public function init()
    {
        parent::init();
    }
}
