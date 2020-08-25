<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
?>
<div class="cases-page">
    <div class="cases-filter-box">
        <div class="container">
            <div class="cases-filter">
                <input type="checkbox" id="ch1" hidden checked>
                <label for="ch1">Design</label>
                <input type="checkbox" id="ch2" hidden>
                <label for="ch2">Photography</label>
                <input type="checkbox" id="ch3" hidden>
                <label for="ch3">Digital Arts</label>
            </div>
        </div>
    </div>

    <div class="cases-list">
        <?php foreach ($models as $model) { ?>
        <div class="case">
            <div class="container">
                <p class="title"><?=$model->title ?></p>
            </div>
            <div class="case-slider">
                <?php for($i = 0; $i < 6; $i++) { ?>
                    <div class="item">
                        <img src="images/case.png" alt="">
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
