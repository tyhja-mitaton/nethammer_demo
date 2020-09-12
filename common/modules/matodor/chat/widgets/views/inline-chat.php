<?php

/** @var yii\web\View $this */
/** @var array $options */

use yii\helpers\Html;

$guiOptions = [
    'container' => $options['containerOptions']['selector'],
    'displayCreateDialog' => true
];

unset($options['containerOptions']['selector']);

echo \matodor\chat\widgets\Chat::widget();
echo Html::tag('div', '', $options['containerOptions']);

unset($options['containerOptions']);

$options = json_encode($options, JSON_FORCE_OBJECT);
$guiOptions = json_encode($guiOptions, JSON_FORCE_OBJECT);

$js = <<<JS
    (function ()
    {
        var options = $.extend(true, {}, Chat.options, $options);
        var dialogsWindow = new Chat.dialogsWindow(options, $guiOptions);

        window['chat_$timestamp'] = dialogsWindow;
    })();
JS;

$this->registerJs($js);

?>

