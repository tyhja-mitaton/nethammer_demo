<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Review */

$this->title = 'Обновить отзыв: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="review-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
/*$js = <<<JS
$(function() {
    let captchaImg = $(document).find('#review-verifycode-image');
  let _captcha = captchaImg.attr('src');
  let captcha = _captcha.replace('/admin', '');
  captchaImg.attr('src', captcha);
});
JS;
$this->registerJs($js);*/
?>
