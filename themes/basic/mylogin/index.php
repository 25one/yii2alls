<?php
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$session = Yii::$app->session;

?>

<?php
$this->title = $model->title.' - index';
?>

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-mylogin-index']);
?>

<?php

    $form = ActiveForm::begin([
       'id' => 'login-form',
       'options' => ['class' => 'form-horizontal'],]);
    ?>
    <div class="form-group">alex - <b>Citadel</b>, serg - <b>Citadel-little</b> (serg - <b>87654321</b>)</div>
    <?= $form->field($model_, 'product_category')->dropdownList(
    $model_->find()->select(['category_name', 'id'])->indexBy('id')->column(),
    ['class' => 'select_field'])->label('Category', array('class'=>'title_select_field'));
    ?>
    <?= $form->field($model, 'username', ['enableClientValidation' => false])->textInput(array('placeholder'=>'enter your login', 'class'=>'login_field', 'value'=>'alex'))->label('Login', array('class'=>'title_login_field'))->hint('(required)', array('class'=>'title_hint')); ?>
    <?= $form->field($model, 'password', ['enableClientValidation' => false])->passwordInput(array('placeholder'=>'enter your password', 'class'=>'password_field', 'value'=>'12345678'))->label('Password', array('class'=>'title_password_field'))->hint('(required)', array('class'=>'title_hint')); ?>
    <span class="title_error_access">&nbsp;</span>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::button('Login', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
