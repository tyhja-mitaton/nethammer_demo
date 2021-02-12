<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 * @var $newModel \frontend\models\Review
 */
use backend\models\SinglePageSeo;
use floor12\files\models\File;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
$mainSeo = SinglePageSeo::findOne(['type' => SinglePageSeo::REVIEWS_PAGE_SEO]);
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
<div class="reviews-page">
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
        <?php if( Yii::$app->session->hasFlash('success-review') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo Yii::$app->session->getFlash('success-review'); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="container">
        <?php Modal::begin([
            'title' => '',
            'toggleButton' => ['label' => 'Оставить отзыв', 'class' => 'btn btn-blue-o'],
            'footer' => '',
            'size' => Modal::SIZE_EXTRA_LARGE,
        ]);

        echo $this->render('_reviewForm', ['model' => $newModel]);

        Modal::end();?>
    </div>

    <div class="container-fluid">
        <div class="reviews-slider owl-carousel owl-theme">
            <?php foreach ($models as $model) {
                $logo = File::find()->where(['object_id' => $model->id, 'field' => 'logo'])->one();?>
                <div class="item">
                    <div class="d-flex align-items-center">
                        <img src="<?=isset($logo->href) ? $logo->href : '' ?>" alt="<?=isset($logo->title) ? $logo->title : ''?>">
                        <div class="name">
                            <?=$model->author ?>
                            <div><?=$model->date ?></div>
                        </div>
                    </div>
                    <div class="text"><?=$model->text ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->title = 'Отзывы';
$js = <<<JS
$('.owl-carousel').owlCarousel({responsive:{768:{items: 3, center: true, loop: true}, 320:{items: 1, center: true, loop: true}}});
JS;
$this->registerJs($js);
?>