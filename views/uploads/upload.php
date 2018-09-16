<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if($model_uploud->place) {
$js = <<<JS
window.parent.document.getElementById("img_photo").setAttribute("src", '/$model_uploud->place');
JS;
$this->registerJs($js);
$session = Yii::$app->session;
$session->set('photo', $model_uploud->place);
}
else {
$session = Yii::$app->session;
$session->set('photo', 'img/nophoto.jpg');	
}
if($model_uploud->validation_error) {
$js = <<<JS
window.parent.document.getElementById("img_error").innerHTML='$model_uploud->validation_error';  
window.parent.document.getElementById("img_photo").setAttribute("src", '/img/nophoto.jpg');
JS;
$this->registerJs($js);
}
else {
$js = <<<JS
window.parent.document.getElementById("img_error").innerHTML='&nbsp;';  
JS;
$this->registerJs($js);
}
?>

<?php $form_uploud = ActiveForm::begin(
	[
	'enableClientValidation' => false,
	'options' => ['enctype' => 'multipart/form-data', 'name' => 'form_upload', 'target' => 'ifr', 'action' => 'upload'],
]) ?>

<?= $form_uploud->field($model_uploud, 'file')->fileInput(['class' => 'upload_field'])->label(false); ?>

<?= Html::submitButton('Submit', ['class' => 'upload_submit']) ?>

<?= Html::button('Select and write', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>

<?= Html::tag('iframe', '', ['name' => 'ifr', 'class' => 'none']) ?>
