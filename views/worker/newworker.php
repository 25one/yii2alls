<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Project;
?>

<div class="menu">

<div class="table">

<div class="table_row">
<div class="table_cell">
<a href="/worker/newworker" class="bolder">Новый сотрудник</a>
</div>
</div>
<div class="table_row">
<div class="table_cell">
<a href="/worker/listworkers">Список сотрудников</a></div>
</div>

</div>

</div>

<div class="content">

<div class="table">

<div class="div_photo">
<div class="table_row">
<div class="table_cell bolder">
<u>Фото</u>
</div>
</div>

<div class="table_row">
<div class="table_cell">
<?= Html::img('/img/nophoto.jpg', ['alt'=>'', 'class'=>'photo_format', 'id' => 'img_photo']);?>
<br><span id="img_error" class="red">&nbsp;</span>
</div>
</div>

<div class="table_row">
<div class="table_cell">
<?php
echo \Yii::$app->runAction('upload');
?>
</div>
</div>
</div>

<?php
    $form = ActiveForm::begin([
       'options' => ['class' => 'form_newworker', 'name' => 'form_newworker'],]);
    ?>     
<div class="table_row">
<div class="table_cell bolder">
<u>ФИО</u> 
</div>
<div class="table_cell">
<?= $form->field($model, 'name')->textInput(array('placeholder'=>'не пустое', 'class'=>'name_title', 'value'=>''))->label(false); ?>
</div>
</div>

<div class="table_row">
<div class="table_cell bolder">
<u>Характеристики:</u> 
</div>
</div>

<?php
$array_characteristics = array(
	'sociability' => 'коммуникабельность',  
	'engineering' => 'инженерные навыки',   
	'timemanagement' => 'тайм менеджмент',
	'languages' => 'знание языков',
);
foreach($array_characteristics as $key_characteristic => $value_characteristic) {
?>
<div class="table_row">
<div class="table_cell bolder">
<?php echo $value_characteristic; ?>
</div>
<div class="table_cell">
<?php
 echo $form->field($model, $key_characteristic)->dropDownList([   
    '0' => '0',   	
    '1' => '1',                                                   
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5',
    '6' => '6',
    '7' => '7',
    '8' => '8',
    '9' => '9',  
    '10' => '10',        
])->label(false);   
?>
</div>
</div> 
<?php
}
?>

<div class="table_row">
<div class="table_cell bolder">
<u>Проект</u> <br><span style="font-size:0.9em;">(несколько,если "тайм менеджмент"=10)</span>
</div>
<div class="table_cell">
<?= Html::activeDropDownList($model, 'id',
      ArrayHelper::map(Project::find()->all(), 'id', 'name'), ['prompt'=>'Выберите']) ?>
</div>
<div class="table_cell">
<ul class="list_project">
&nbsp;
</ul>
</div>
</div>

<hr>

<div class="table_row">
<div class="table_cell">
<?php 
?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>
</div>
<?php
 echo $form->field($model, 'id_projects', ['options' => ['class'=> 'id_projects']])->hiddenInput()->label(false); 
?>   
<?php ActiveForm::end() ?>

<div class="table_row">
<div class="table_cell">
<span class="title_error">&nbsp;</span> 
</div>
</div>

</div>

</div>

