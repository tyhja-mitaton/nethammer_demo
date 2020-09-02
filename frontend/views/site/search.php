<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Поиск';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html; ?>
<div class="search-page">
    <div class="container">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <nav>
            <?= Breadcrumbs::widget([
                'tag' => 'ol',
                'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                'homeLink' => ['label' => 'Главная', 'url' => '/'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </nav>
    </div>
    <div class="container">
        <?php foreach ($models as $model) { ?>
        <div class="item">
            <a href="<?=$model->url ?>"><h3 class="page-title"><?=$model->title ?></h3></a>
            <div class="text"><?=$model->description ?></div>
        </div>
        <?php } ?>
    </div>
</div>
