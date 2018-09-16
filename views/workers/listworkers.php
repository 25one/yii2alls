<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>

<div class="menu">

<div class="table">

<div class="table_row">
<div class="table_cell">
<a href="/workers/newworker">New employee</a>
</div>
</div>
<div class="table_row">
<div class="table_cell">
<a href="/workers/listworkers" class="bolder">A list of employees</a></div>
</div>

</div>

</div>

<div class="content">

<div class="table" style="display:inline-block;">
<div class="table_row">
<div class="table_cell bolder">
Search by "Full name" <input type="text" name="text_search" placeholder="" />
</div>
<div class="table_cell">
<button type="button" class="btn btn-primary" name="button_search">To find</button>
</div>
</div>
</div>

<div class="table table_list">
<div class="table_row bolder center inverter">
<div class="table_cell border">
Full name
</div>
<div class="table_cell border">
Photo
</div>
<div class="table_cell border">
Characteristics
</div>
<div class="table_cell border">
Number of projects
</div>
<div class="table_cell border">
Remove
</div>
</div>
<?php
foreach($list as $key => $value) {
?>
<div class="table_row tr_list">
<div class="table_cell border">
<?php echo $value['name']; ?>
</div>
<div class="table_cell border center">
<img src="/<?php echo $value['photo']; ?>" class="photo_format" alt="" />
</div>
<div class="table_cell border middle">
<?php 
$characteristics = '';
$characteristics .= 'sociability:'.$value['sociability'].'<br>';
$characteristics .= 'engineering skills:'.$value['engineering'].'<br>';
$characteristics .= 'time management:'.$value['timemanagement'].'<br>';
$characteristics .= 'knowledge of languages:'.$value['languages'].'<br>';
echo $characteristics;
?>
</div>
<div class="table_cell border center">
<?php 
echo $value['result']; 
?>
</div>
<div class="table_cell border center">
<button type="button" id="<?php echo $value['id']; ?>" class="button_remove btn btn-primary" name="/<?php echo $value['photo']; ?>">remove</button>
</div>
</div>
<?php
}
?>
</div>

<hr>

<div>
<?php 
echo 'Average of "sociability":<b>'.$average[0]['average_sociability'].'</b><br>';
echo 'Average of "engineering skills":<b>'.$average[0]['average_engineering'].'</b><br>';
echo 'Average of "time management":<b>'.$average[0]['average_timemanagement'].'</b><br>';
echo 'Average of "knowledge of languages":<b>'.$average[0]['average_languages'].'</b><br>';
?>
</div>

</div>

