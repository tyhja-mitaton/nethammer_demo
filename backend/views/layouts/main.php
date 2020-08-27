<?php
use yii\helpers\Html;

/** @var \yii\web\View$this  */
/** @var string $content */

/*if (\Yii::$app->user->isGuest)
{
    echo $this->render('unauthorized', $_params_);
    return;
}*/

backend\assets\AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title . ' - ' . \Yii::$app->name) ?></title>
            <?php $this->head() ?>
        </head>
        <body class="skin-black-light sidebar-mini">
            <?php $this->beginBody() ?>
                <div class="wrapper">
                    <?= $this->render('header.php', ['directoryAsset' => $directoryAsset]) ?>
                    <?= $this->render('left.php', ['directoryAsset' => $directoryAsset])?>
                    <?= $this->render('content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]) ?>
                </div>
            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>
