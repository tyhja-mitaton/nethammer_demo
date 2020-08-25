<?php
/**
 * @var $this yii\web\View
 * @var $provider yii\data\ActiveDataProvider
 * @var $appeal frontend\models\Appeal
 */
$this->title = 'Nethammer';

$models = $provider->getModels();
?>
<div class="home-page">
    <div class="container">
        <div class="home-slider owl-carousel owl-theme">
        <?php $i = 0; foreach ($models as $model) {$i++ ?>
            <div class="item">
                <div class="row align-items-center">
                    <div class="col-md-6 order-md-1">
                        <img src="images/slide<?=$i ?>.png" alt="">
                    </div>
                    <div class="col-md-6">
                        <p class="title"><?=$model->title ?></p>
                        <p><?=$model->description ?></p>
                        <a class="btn btn-white" href="html/service-page.php">
                            <?=$model->btn_name ?> <i>→</i>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1">
                            <img src="images/grafic.png" alt="">
                            <span>
                                        <b>Опыт и технологии</b> <span>заголовком/цифрами и небольшим описанием</span>
                                    </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2">
                            <img src="images/steps.png" alt="">
                            <span>
                                        <b>Направление работы</b> <span>может преимущества или еще какая-то визуальная штука с</span>
                                    </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab3">
                            <img src="images/people.png" alt="">
                            <span>
                                        <b>Клиенты</b> <span>заголовком/цифрами и небольшим описанием</span>
                                    </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab4">
                            <img src="images/products.png" alt="">
                            <span>
                                        <b>Продукты</b> <span>заголовком/цифрами и небольшим описанием</span>
                                    </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab1">
                        <p class="tab-title">Описание</p>
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                    </div>
                    <div class="tab-pane fade" id="tab2">
                        <p class="tab-title">Описание</p>
                        <p>Dim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                    </div>
                    <div class="tab-pane fade" id="tab3">
                        <p class="tab-title">Описание</p>
                        <p>Cnim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                    </div>
                    <div class="tab-pane fade" id="tab4">
                        <p class="tab-title">Описание</p>
                        <p>Znim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render('_contact', ['model' => $appeal]); ?>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 1}}});
});
JS;
$this->registerJs($js);
?>