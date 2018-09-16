<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="form">

<div class="table">
<?php
$form = ActiveForm::begin(['options' => ['class' => 'form_cartree', 'name' => 'form_cartree'],]); 
?>

<?php 
foreach($list as $key_row => $value_row) {

?>  
<div class="table_row">
<div class="table_cell">
   <?php
      echo $form->field($model, 'checkbox')
                ->checkbox([
                   'value' => $value_row['id'],
                   'label' => $value_row['name'],
                   'class' => 'ch',
                ]);   
   ?>
</div>
</div>
<?php
}
?>

<?php ActiveForm::end() ?>

</div>

</div>

<div class="content">

</div>
