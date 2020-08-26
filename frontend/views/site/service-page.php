<?php
/**
 * @var $model common\models\InfoBlock
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
$avatar = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'avatar'])->one();
?>
<div class="container">
<div class="service-page">
    <div class="row mb-5 align-items-center">
        <div class="col-lg-6 order-lg-1 mb-4 text-center">
            <img src="<?=isset($avatar->href) ? $avatar->href : '' ?>" alt="">
        </div>
        <div class="col-lg-6">
            <?=$model->description ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-4">
            <p class="h2">Как строится работа</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-4">
            <div class="how-box">
                <img src="images/time.png" alt="">
                <span>Быстро</span>
            </div>
            <div class="how-box">
                <img src="images/diamond.png" alt="">
                <span>Качественно</span>
            </div>
        </div>
        <div class="col-lg-8 pt-lg-4">
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <p class="h2">Сколько стоит</p>
            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>
        </div>
    </div>
</div>
</div>