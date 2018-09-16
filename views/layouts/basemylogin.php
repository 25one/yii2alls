<?php

use yii\helpers\Html;

$this->registerJsFile('js/jquery-1.11.2.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/mylogin.js');
$this->registerCssFile('css/mylogin.css');
$this->registerCssFile('css/app.css');

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

<?php $this->beginContent('@app/views/mylogin/header.php'); ?>
<?php $this->endContent(); ?>
<hr>
<div class="wrap">

    <div class="container">
        <?=
           $content;
        ?>
    </div>

</div>
<hr>
<?php $this->beginContent('@app/views/mylogin/footer.php'); ?>
<?php $this->endContent(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>