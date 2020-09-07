<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

$models = $provider->getModels();
$appealModel = new \frontend\models\Appeal();
 ?>
<div class="job-page">
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
<section class="job-list">
    <div class="container">
        <div class="accordion" id="vacancies">
            <?php $i = 0; foreach ($models as $model) { $i++; ?>
                <div class="vacancy">
                    <h2 class="job-title" data-toggle="collapse" data-target="#vacancy<?=$i/*$model->iterator->key()*/ ?>">
                        <?=$model->title ?> <span><?=$model->salary ?> руб</span>
                    </h2>
                    <div id="vacancy<?=$i ?>" class="collapse <?=$i === 1 ? 'show':'' ?>" data-parent="#vacancies">
                        <?=$model->description ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
    <?= $this->render('_contact', ['model' => $appealModel]); ?>
</div>
<?php
$js = <<<JS
var formatter = new Intl.NumberFormat("ru", {/*style: "currency", currency: "RUB"*/});
$(function() {
  $(document).find('h2.job-title span').each(function() {
    let salary = parseInt($(this).text(), 10);
    let fSalary = formatter.format(salary);
    $(this).text(fSalary + ' руб');
  })
});
JS;
$this->registerJS($js)
?>