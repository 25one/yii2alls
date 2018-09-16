<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
//use app\components\MyClass; //...!!!ЭТО БЫЛА НАСТРОЙКА ДЛЯ web.php - ЕСЛИ ТАМ ЗАКОМЕНТИЛИ (АЛЬТЕРНАТИВА - ServiceLocator)...НИЖЕ...
use app\components\Foo;
use yii\di\ServiceLocator;

$foo= new Foo;

$locator = new ServiceLocator;    //...!!!ServiceLocator...
$locator->set('myclass', function () {
    return new app\components\MyClass; //...!!!ServiceLocator...
});
$myclass = $locator->get('myclass'); //...!!!ServiceLocator...

?>

<?php
$this->title = 'title-index';
//$this->title = $model->title;
?>

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'title-index - yii, framework, php']);
?>

<?php $this->beginContent('@app/views/mymod/menu.php'); ?>
<?php $this->endContent(); ?>

<?php if (isset($this->blocks['block_menu1'])): ?>
    <?= $this->blocks['block_menu1'] ?>
<?php else: ?>
    ... контент по умолчанию для блока 1 ...
<?php endif; ?>

<div class="container_login">

<?php
//\Yii::$app->myclass->display('Привет мир');                                        //...!!!ЭТО БЫЛА НАСТРОЙКА ДЛЯ web.php
//\Yii::$app->myclass->label='Hello world';           //...СЕТТЕР - ЗАНЕСЕНИЕ...     //...!!!ЭТО БЫЛА НАСТРОЙКА ДЛЯ web.php
//echo '<br>'.Html::encode(\Yii::$app->myclass->label); //...ГЕТТЕРЫ - ИЗВЛЕЧЕНИЕ... //...!!!ЭТО БЫЛА НАСТРОЙКА ДЛЯ web.php
$myclass->display('Привет мир');                                        //...!!!ServiceLocator...
$myclass->label='Hello world';           //...СЕТТЕР - ЗАНЕСЕНИЕ...     //...!!!ServiceLocator...
echo '<br>'.Html::encode($myclass->label); //...ГЕТТЕРЫ - ИЗВЛЕЧЕНИЕ... //...!!!ServiceLocator...
?>
<br>
<?php
// обработчик - анонимная функция
$foo->on(Foo::EVENT_HELLO, function ($event) {
    // логика обработки события
    print_r($event->name);
});
//$foo->on(Foo::EVENT_HELLO, [$object, 'methodName'], 'abc');
$foo->bar(); //...ТАМ trigger - ПОЭТОМУ ЭТО НУЖНО ВЫЗЫВАТЬ (Т.Е. - on "ПРИВЯЗЫВАЕТ", trigger - "ВЫЗЫВАЕТ/ВЫПОЛНЯЕТ")
?>

<h2><?= Html::encode($model->title) ?></h2>

ID of ocontroller: <?= $this->context->id ?>

<h3><?= Html::encode($model->language) ?></h3>

<h3><?= Html::encode($prop_behaviors) ?></h3>

<?php $form = ActiveForm::begin(['options' => ['name' => 'login_form']]); ?>

<div class="table_login">

<div class="row_td">
<div class="cell_td title_login">
    Login
</div>
<div class="cell_td">                                <!-- error(false) (...'login', ['errorOptions' => ['tag' => null]]) -->
    <?= $form->field($model, 'login')->label(false)->error(false)->textInput(array('placeholder'=>'enter your login', 'class'=>'login_field', 'value'=>'alex')); ?> <div class="elem_title_validate">(a-zA-Z0-9_)</div>
</div>                                                                                                                                        <!-- 'name'=>'login_field' -->
</div>
<div class="row_td">
<div class="cell_td title_login">
    Password
</div>
<div class="cell_td">                                   <!-- error(false) (...'password', ['errorOptions' => ['tag' => null]]) -->
    <?= $form->field($model, 'password')->label(false)->error(false)->textInput(array('placeholder'=>'enter your password', 'class'=>'password_field', 'value'=>'12345678', 'type'=>'password')); ?> <div class="elem_title_validate">(a-zA-Z0-9_)</div>
</div>                                                                                                                                               <!-- 'name'=>'password_field' -->
</div>
<div class="row_td">
<?= $form->field($model, 'from_date')->widget(DatePicker::classname(), [
                //'options' => ['placeholder' => 'Enter date ...'],
                //'options' => ['value' => '19 Апр 2018 г.'],
    'language' => 'ru',
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
    ],

            ])->textInput(array('value'=>'9 Апр 2018 г.')); ?>
</div>
<div class="row_td">
<div class="cell_td">
    <?= Html::button('Login', ['class' => 'btn_login']) ?>
</div>
<div class="cell_td">
<div class="elem_title_error">
<?php
if($errors_validate) {      //...ЕСЛИ НЕ ВИДЖЕТ ActiveForm (error(false))...
//print_r($errors);
//echo '<ul>';
//foreach($errors as $key_errors=>$title_errors) {  //...ЕСЛИ НЕ КОНКРЕТНЫЕ СТАНДАРТНЫЕ СООБЩЕНИЯ ОБ ОШИБКАХ...
//echo '<li>'.$title_errors[0].'</li>';
//}
//echo '</ul>';
echo 'Bad format of field!';
}
if($errors_autentificate) {
echo $errors_autentificate;
}
?>
</div>
</div>
</div>

</div>

<?php ActiveForm::end(); ?>

<br>
<div class="container_request">
<input type="text" name="text_request_get" class="text_request_get" value="example of get" /> <button type="button" class="button_request_get">Get-location...</button>
<br><br>
<?php $form = ActiveForm::begin(['options' => ['name' => 'form_request_post', 'method' => 'post'], 'action' => ['mymod/requestpage']]); ?>
<?= $form->field($model, 'guest')->label(false)->textInput(array('class'=>'text_request_post', 'value'=>'example of post')); ?>
<br>
<?= Html::button('Post', ['class' => 'button_request_post']) ?>
<?php ActiveForm::end(); ?>
<br>
<input type="text" name="text_ajax_get" class="text_ajax_get" value="example of ajax-get" /> <button type="button" class="button_ajax_get">Get-ajax+JSON...</button>
<div class="request_place_ajax">
</div>
<br>
<button type="button" class="button_download">Download the file...</button>
<div class="error_download">
<?= Html::encode($model->error_download) ?>
</div>
</div>

</div>
