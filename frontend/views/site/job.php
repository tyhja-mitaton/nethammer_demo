<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
$appealModel = new \frontend\models\Appeal();
 ?>
<div class="job-page">
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
    <?= $this->render('contact', ['model' => $appealModel]); ?>
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