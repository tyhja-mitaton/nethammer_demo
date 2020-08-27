<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Поиск';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
?>
<div class="search-page">
    <div class="container-fluid">
        <?php foreach ($models as $model) { ?>
        <div class="item">
            <div class="name"><?=$model->title ?></div>
            <div class="text"><?=$model->description ?></div>
        </div>
        <?php } ?>
    </div>
</div>
