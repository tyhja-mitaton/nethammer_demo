<?php

/** @var yii\web\View $this */
/** @var array $options */

use yii\helpers\Html;

$guiOptions = [
    'toggleSelector' => $options['toggleOptions']['selector'],
    'container' => $options['containerOptions']['selector'],
    'popupWrapper' => $options['containerWrapperOptions']['selector'],
    'displayCreateDialog' => true
];

unset($options['toggleOptions']['selector']);
unset($options['containerOptions']['selector']);
unset($options['containerWrapperOptions']['selector']);

echo \matodor\chat\widgets\Chat::widget();
echo Html::tag('div', '', $options['toggleOptions']);
echo Html::tag('div',
    Html::tag('div', '', $options['containerOptions']) .
    Html::tag('div', '', ['class' => 'dialogs-container_triangle']),
$options['containerWrapperOptions']);

unset($options['toggleOptions']);
unset($options['containerOptions']);
unset($options['containerWrapperOptions']);

$options = json_encode($options, JSON_FORCE_OBJECT);
$guiOptions = json_encode($guiOptions, JSON_FORCE_OBJECT);

$js = <<<JS
    (function ()
    {
        var options = $.extend(true, {}, Chat.options, $options);
        var selectors = $guiOptions;
        var popup = new Chat.popup(options, selectors);

        window['chat_$timestamp'] = popup;
        $(selectors.toggleSelector).data('chat', popup);
    })();
JS;

$this->registerJs($js);

?>

