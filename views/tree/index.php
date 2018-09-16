<?php

use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tree</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container_dom_result">
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>