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
$caseUpperBlock = \backend\models\CaseUpperBlock::find()->one();
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
    <div class="cases-filter-box" style="padding-bottom: 10px; <?=(isset($caseUpperBlock->text) && $caseUpperBlock->text != '') ? 'padding-top: 10px;' : ''?>">
        <?php if(isset($caseUpperBlock->text) && $caseUpperBlock->text != ''):?>
            <div class="container case-upper-block"><?=$caseUpperBlock->text?></div>
        <?php endif;?>
        <div class="container">
            <div class="cases-filter">
                <?php foreach ($tags as $key => $tag){ ?>
                    <input type="checkbox" id="ch<?=$key?>" hidden checked>
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
                        <a class="img" href="<?=$img->href?>" data-fancybox="cases-gallery-<?=$model->id?>" title="<?=$img->title?>" data-type="image">
                        <?=Html::img($img->href); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="case-text">
                <p><b>О проекте</b></p>
                <p><?=$model->intro ?></p>
                <br>
                <p><?=$model->description ?></p>
            </div>
            <p class="case-more">
                <a href="#">
                    <span><?=$model->btn_name?></span>
                    <span style="display:none;">Свернуть</span>
                </a>
            </p>
        </div>
        <?php } ?>
    </div>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
    $('.case-more a').on('click', function(e){
    e.preventDefault();
    $(this).closest('.case').find('.case-text').toggleClass('full');
    $(this).find('span').toggle();
    });
    
  $('.owl-carousel').owlCarousel({center: true, loop: true, responsive:{768:{items: 3}, 320:{items: 1}}});
  let galleryConts = $('.owl-carousel');
  galleryConts.each(function(index) {
    $(this).find('.item .img').fancybox({
	/*afterLoad: function () {
            $('.fancybox-content').width(parseInt($('.fancybox-iframe').contents().find('html img').width()));
            $('.fancybox-content').height(parseInt($('.fancybox-iframe').contents().find('html img').height()));
    },*/
    infobar: false
  });
  });
  /*$('[data-fancybox="cases-gallery"]').fancybox({
	afterLoad: function () {
            $('.fancybox-content').width(parseInt($('.fancybox-iframe').contents().find('html img').width()));
            $('.fancybox-content').height(parseInt($('.fancybox-iframe').contents().find('html img').height()));
    },
    infobar: false
  });*/
  filterCases.call($('.cases-filter input:checked'));
  $('.owl-carousel').trigger('to.owl.carousel', [0]);
  //$('.owl-carousel').jumpTo(0);
  $('.cases-filter input').on('click', filterCases);
});

function filterCases() {
  let checkedInputs = $(this).closest('.cases-filter').find('input:checked');
    let tagTypes = [];
    checkedInputs.each(function(index) {
      tagTypes.push(parseInt($(this).attr('id').substring(2)));
    });
    
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