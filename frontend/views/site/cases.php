<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */

use backend\models\SinglePageSeo;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

$models = $provider->getModels();
$mainSeo = SinglePageSeo::findOne(['type' => SinglePageSeo::CASES_PAGE_SEO]);
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
$tags = \common\models\InfoBlock::getTags();
?>
<div class="cases-page">
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
    <div class="cases-filter-box">
        <div class="container">
            <div class="cases-filter">
                <?php foreach ($tags as $key => $tag){ ?>
                    <input type="checkbox" id="ch<?=$key?>" hidden <?=$key == 1 ? 'checked': ''?>>
                    <label for="ch<?=$key?>"><?=$tag?></label>
                <?php }?>
            </div>
        </div>
    </div>

    <div class="cases-list">
        <?php foreach ($models as $model) {
            $imgModels = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->all();?>
        <div class="case" data-tag="<?=$model->tag?>">
            <div class="container">
                <p class="title"><?=$model->title ?></p>
            </div>
            <div class="case-slider owl-carousel owl-theme">
                <?php foreach ($imgModels as $img) { ?>
                    <div class="item">
                        <?=Html::img($img->href); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="case-text">
                <p><b>О проекте</b></p>
                <p><?=$model->description ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 3, center: true, loop: true}, 320:{items: 1, center: true, loop: true}}});
  filterCases.call($('.cases-filter input:checked'));
});
$('.cases-filter input').on('click', filterCases);
function filterCases() {
  let checkedInputs = $(this).closest('.cases-filter').find('input:checked');
    let tagTypes = [];
    checkedInputs.each(function(index) {
      tagTypes.push(parseInt($(this).attr('id').substring(2)));
    });
    console.log(tagTypes);
    let cases = $('.cases-list .case');
    
  cases.each(function(index) {
      if(!tagTypes.includes($(this).data('tag'))) {
      $(this).addClass('d-none');
      }else {
          $(this).removeClass('d-none');
      }
    });
}
JS;
$this->registerJs($js);
?>