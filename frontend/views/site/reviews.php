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

        <button type="button" class="btn btn-blue-o show-modal-btn show-modal-btn__offset" data-toggle="modal" data-target="#w1">Оставить отзыв</button>
    </div>

    <?php if( Yii::$app->session->hasFlash('success-review') ): ?>
        <div class="container">
            <div class="alert alert-success alert-dismissible my-4" role="alert">
                <?php echo Yii::$app->session->getFlash('success-review'); ?>
            </div>
        </div>
    <?php endif;?>

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

<?php Modal::begin([
    'title' => '',
    'footer' => '',
    'size' => Modal::SIZE_EXTRA_LARGE,
]); ?>
    <?= $this->render('_reviewForm', ['model' => $newModel]); ?>
<?php Modal::end();?>

<?php $this->title = 'Отзывы';
$js = <<<JS
$('.owl-carousel').owlCarousel({startPosition: 1, responsive:{768:{items: 3, center: true, loop: true}, 320:{items: 1, center: true, loop: true}}});
$('.owl-carousel').trigger('to.owl.carousel', [0]);
JS;
$this->registerJs($js);
?>
