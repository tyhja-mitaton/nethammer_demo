<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
 ?>
<div class="job-page">
<section class="job-list">
    <div class="container">
        <div class="accordion" id="vacancies">
            <div class="vacancy">
                <h2 class="job-title" data-toggle="collapse" data-target="#vacancy1">
                    Frontend-разработчик <span>45 000 руб</span>
                </h2>
                <div id="vacancy1" class="collapse show" data-parent="#vacancies">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
            <?php foreach ($models as $model) { ?>
                <div class="vacancy">
                    <h2 class="job-title" data-toggle="collapse" data-target="#vacancy<?=$model->iterator->count() ?>">
                        <?=$model->title ?>
                    </h2>
                    <div id="vacancy<?=$model->iterator->count() ?>" class="collapse" data-parent="#vacancies">
                        <?=$model->description ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="contact-us">
    <div class="container">
        <h2 class="section-title">Связаться с нами</h2>
        <form>
            <div class="form-group error">
                <label>Имя</label>
                <input class="form-control" type="text" placeholder="Дмитрий" value="site@mail.ru">
            </div>
            <div class="form-group">
                <label>E-mail или телефон</label>
                <input class="form-control" type="text" placeholder="+7 995 995 95 95">
            </div>
            <button class="btn btn-blue">
                Отправить <i class="fas fa-chevron-right"></i>
            </button>
            <img src="images/contacts-robot.jpg" alt="">
        </form>
    </div>
</section>
</div>