<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

?>


<?php
$this->title = $model->title.' - index';
?>

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-mylogin-index']);
?>

<?php
//print_r(Url::home()); echo '<br>';
//print_r(Url::home(true)); echo '<br>';
?>

<!--
<?= Html::beginForm(['/', 'id' => 'select_example'], 'post', ['name' => '', 'class' => '']) ?>

<?= Html::activeDropDownList($model_, 'id', ArrayHelper::map(

    ArrayHelper::toArray($model_->find()->select(['id', 'category_name'])->all(), [
    'app\models\ProductCategory' => [
        'id',
        //'category_name',
        // ключ в результирующем массиве => анонимная функция
        'category_name_and_length' => function ($model_) {
            //return strlen($post->content);
            //return '--'.$model_->find()->select(['id', 'category_name'])->all()->category_name;
            return '--'.$model_->category_name;
        },
    ],
]),

//$model_->find()->select(['id', 'category_name'])->asArray()->all(),
//'id', 'category_name'))
'id', 'category_name_and_length'))
?>

<?= Html::endForm() ?>
-->

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

<?= Html::a(\Yii::t('app', 'Contact us'), ['mylogin/mailer']); ?>

<?= Html::script('
//document.body.style.backgroundColor="lightblue";    //...!!!САМОСТОЯТЕЛЬНО "ВКРАПЛЕННЫЙ" В view js ИЛИ НИЖЕ В ВИДЕ ФАЙЛА...
', ['defer' => true]); ?>

<?= Html::jsFile('@web/js/mylogin_single.js') ?>

<?php


$js = <<<JS
$(document).ready(function(){
//$("body").css("background-color", "lightblue");   //...!!!ИЛИ ВОТ ТАК...
});
JS;


/*
$js = <<<JS
$('form').on('beforeSubmit', function(){
var data = $(this).serialize();
$.ajax({
//url: '/mylogin/ajaxagain',
//type: 'POST',
url: '?r=mylogin/ajaxagain',
type: 'GET',
data: data,
success: function(res){
console.log(res);
},
error: function(){
alert('Error!');
}
});
return false;
});
JS;
*/

$this->registerJs($js);

?>

