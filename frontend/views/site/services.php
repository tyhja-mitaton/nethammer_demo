<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */

use backend\models\SinglePageSeo;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
$mainSeo = SinglePageSeo::findOne(['type' => SinglePageSeo::SERVICES_PAGE_SEO]);
if($mainSeo) {
    $this->registerMetaTag([
        'name' => 'og:title',
        'content' => $mainSeo->seo->title,
    ]);
    $this->registerMetaTag([
        'name' => 'og:description',
        'content' => $mainSeo->seo->description,
    ]);

    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $mainSeo->seo->keywords,
    ]);
}
?>
<div class="category-page">
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
    <section class="category-list">
        <?php $i = 0; foreach ($models as $model) { $i++;
            $avatar = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'avatar'])->one();?>
        <div class="item">
            <div class="container">
                <h2 class="title"><?=$model->title ?></h2>
                <img class="img" src="<?=isset($avatar->href) ? $avatar->href : '' ?>" alt="">
                <div class="desc"><?=$model->description ?></div>
                <?= Html::a("$model->btn_name <i>→</i>", [\yii\helpers\Url::to(['service-page', 'id' => $model->id, 'slug' => \yii\helpers\Inflector::slug($model->title)])], ['class' => 'btn btn-blue-o']) ?>
            </div>
        </div>
        <?php } ?>
    </section>
</div>
