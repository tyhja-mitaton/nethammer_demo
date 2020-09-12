<?php

/* @var $this yii\web\View */

$this->title = 'Админ-панель';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Раздел администратора</h1>

        <?= \matodor\chat\widgets\InlineChat::widget([
            'options' => [
                'requestParams' => [],
            ]
        ]); ?>
    </div>
</div>
