<?php

namespace matodor\chat\widgets;

use Yii;
use yii\base\Widget;
use matodor\chat\assets\ChatAssets;
use yii\helpers\ArrayHelper;

class InlineChat extends Widget
{
    /**
     * Массив настроек виджета:
     *    requestParams Массив дополнительных пар ключ-значение передаваемых в запросе подключения
     *    containerOptions Массив настроек передаваемый в Html::tag для container элемента
     * @var array
     */
    public $options = [];

    public function init()
    {
        parent::init();
        ChatAssets::register($this->getView());
    }

    public function run()
    {
        $timestamp = time();
        $options = [
            'openIfClosed' => true,
            'requestParams' => new \stdClass(),
            'containerOptions' => [
                'selector' => '.dialogs-container-' . $timestamp,
                'class' => [
                    'dialogs-container',
                    'dialogs-container_inline',
                    'dialogs-container-' . $timestamp
                ]
            ]
        ];

        $options = ArrayHelper::merge($options, $this->options);

        return $this->render('inline-chat', [
            'options' => $options,
            'timestamp' => $timestamp
        ]);
    }
}

?>