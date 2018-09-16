<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php

?>

<div class="post-search">
    <?php $form = ActiveForm::begin([
        'action' => ['login'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(array('placeholder'=>'', 'class'=>'login_field', 'value'=>'0'))->label('id >', array('class'=>'title_login_field')) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
