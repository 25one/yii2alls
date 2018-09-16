<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UploadForm;

?>

<?php

    $model_=new UploadForm;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model_, 'imageFiles[]')->fileInput((['multiple' => true, 'accept' => 'image/*'])) ?>

<?php
//...imageFiles[] (!s) + ['multiple' => true, 'accept' => 'image/*']- ÄËß ÌÍÎÆÅÑÒÂÅÍÍÎÉ ÇÀÃĞÓÇÊÈ ÔÀÉËÎÂ...
?>

    <button>Submit</button>

<?php ActiveForm::end() ?>


