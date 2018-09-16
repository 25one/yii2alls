<?php
use yii\helpers\Html;
//print_r($model);
?>

<?php
$this->title = 'title-request';
?>

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-request - yii, framework, php']);
?>

<h2>Request: </h2>
<hr>
<div class="request_place">
<ul>
<li>
<?=
Html::encode($model->requestexample['title']); //...ме $model->requestexample->title
?>
</li>
<li>
<?=
Html::encode($model->requestexample['method']);
?>
</li>
</ul>
</div>
