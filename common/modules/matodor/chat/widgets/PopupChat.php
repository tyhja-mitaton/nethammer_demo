<?php

namespace matodor\chat\widgets;

use Yii;
use yii\base\Widget;
use matodor\chat\assets\ChatAssets;
use yii\helpers\ArrayHelper;

class PopupChat extends Widget
{
    /**
     * Массив настроек виджета:
     *    openIfClosed - Открывать ли окно с чатом при получении сообщений
     *    requestParams Массив дополнительных пар ключ-значение передаваемых в запросе подключения
     *    toggleOptions Массив настроек передаваемый в Html::tag для toggle элемента
     *    containerOptions Массив настроек передаваемый в Html::tag для container элемента
     *    containerWrapperOptions Массив настроек передаваемый в Html::tag для container-wrapper элемента
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
            'toggleOptions' => [
                'selector' => '.chat-toggle-' . $timestamp,
                'class' => [
                    'chat-toggle',
                    'chat-toggle-popup',
                    'chat-toggle-' . $timestamp
                ]
            ],
            'containerWrapperOptions' => [
                'selector' => '.dialogs-container_wrapper-' . $timestamp,
                'class' => [
                    'dialogs-container_wrapper',
                    'dialogs-container_wrapper-popup',
                    'dialogs-container_wrapper-' . $timestamp
                ]
            ],
            'containerOptions' => [
                'selector' => '.dialogs-container-' . $timestamp,
                'class' => [
                    'dialogs-container_popup',
                    'dialogs-container',
                    'dialogs-container-' . $timestamp
                ]
            ]
        ];

        $options = ArrayHelper::merge($options, $this->options);

        return $this->render('popup-chat', [
            'options' => $options,
            'timestamp' => $timestamp
        ]);
    }
}

?>