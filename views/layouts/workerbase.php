<?php

use yii\helpers\Html;

$this->registerJsFile('/js/jquery-1.11.2.js', ['position' => \yii\web\View::POS_HEAD]);  //...!!!in header
$this->registerJsFile('/js/worker.js');
$this->registerCssFile('/css/app.css');
$this->registerCssFile('/css/worker.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head(); ?>
</head>
<body>

<?php $this->beginBody() ?>

<div class="wrap">

   <?=
      $content;
   ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>