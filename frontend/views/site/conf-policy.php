<?php
/**
 * @var $confidPolModel \backend\models\ConfidPol;
 */

?>
<div class="confid-page">
    <div class="container">
        <h1 class="page-title">Политика конфиденциальности</h1>
        <div><?=isset($confidPolModel->text) ? $confidPolModel->text : ''?></div>
    </div>
</div>
