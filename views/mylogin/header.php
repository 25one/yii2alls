<?php

use yii\bootstrap\Html;

if(\Yii::$app->language == 'ru'):
    echo Html::a('English', [\Yii::$app->controller->route, 'language' => 'en'], ['class' => 'link_language', 'value' => 'ru']);
else:
    echo Html::a('Russian', [\Yii::$app->controller->route, 'language' => 'ru'], ['class' => 'link_language', 'value' => 'en']);
endif;


?>

<h3><?= \Yii::t('app', 'Here will be a HEADER...'); ?></h3>