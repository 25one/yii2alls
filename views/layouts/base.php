<?php

//use app\assets\AppAsset;
use yii\web\View;         //...!!!ДЛЯ View + ИМЕННО ДЛЯ КОНСТАНТ ТИПА EVENT_END_BODY - ИЗ web (Т.К. ЕСТЬ ЕЩЕ ИЗ base)
use yii\helpers\Html;
use yii\widgets\ActiveForm;

//AppAsset::register($this);
//...БЕЗ AppAsset - СВОЕ ОТДЕЛЬНО ДЛЯ СТРАНИЦЫ...(В Т.Ч. - JQ - ТУТ (В ОТЛИЧИЕ ОТ AppAsset) САМО НЕ ПОДХВАТЫВАЕТСЯ...)
$this->registerJsFile('js/jquery-1.11.2.js');
$this->registerJsFile('js/mymod.js');
$this->registerCssFile('css/mymod.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>
<body>

<?php
\Yii::$app->view->on(View::EVENT_END_BODY, function () {
    echo date('Y-m-d');
});
?>

<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">
        <?=
           $content; //...!!!!!ЭТО СОДЕРЖИМОЕ index.php
        ?>
    </div>

</div>

<?php $this->beginContent('@app/views/mymod/footer.php'); ?>
<?php $this->endContent(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>