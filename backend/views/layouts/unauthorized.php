<?php
use yii\helpers\Html;

/** @var \yii\web\View$this  */
/** @var string $content */

backend\assets\AppAsset::register($this);

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body class="unathorized">
            <?php $this->beginBody() ?>
                <div class="unathorized-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>
