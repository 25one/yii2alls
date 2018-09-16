<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <b><?= Html::encode($model->id) ?></b> - <?= HtmlPurifier::process($model->name) ?>
</div>

