<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Projects;
?>

<div class="menu">

<div class="table">

<div class="table_row">
<div class="table_cell">
<a href="/workers/newworker" class="bolder">New employee</a>
</div>
</div>
<div class="table_row">
<div class="table_cell">
<a href="/workers/listworkers">A list of employees</a></div>
</div>

</div>

</div>

<div class="content">

<div class="table">

<div class="div_photo">
<div class="table_row">
<div class="table_cell bolder">
<u>Photo</u>
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
echo \Yii::$app->runAction('uploads');
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
<u>Full name</u>
</div>
<div class="table_cell">
<?= $form->field($model, 'name')->textInput(array('placeholder'=>'not empty', 'class'=>'name_title', 'value'=>''))->label(false); ?>
</div>
</div>

<div class="table_row">
<div class="table_cell bolder">
<u>Characteristics:</u>
</div>
</div>

<?php
$array_characteristics = array(
	'sociability' => 'sociability',
	'engineering' => 'engineering skills',
	'timemanagement' => 'time management',
	'languages' => 'knowledge of languages',
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
<u>Project</u> <br><span style="font-size:0.9em;">(several if "time management"=10)</span>
</div>
<div class="table_cell">
<?= Html::activeDropDownList($model, 'id',
      ArrayHelper::map(Projects::find()->all(), 'id', 'name'), ['prompt'=>'Select']) ?>
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
<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
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

