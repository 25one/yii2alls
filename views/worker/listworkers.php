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
<a href="/worker/newworker">Новый сотрудник</a>
</div>
</div>
<div class="table_row">
<div class="table_cell">
<a href="/worker/listworkers" class="bolder">Список сотрудников</a></div>
</div>

</div>

</div>

<div class="content">

<div class="table" style="display:inline-block;">
<div class="table_row">
<div class="table_cell bolder">
Поиск по ФИО <input type="text" name="text_search" placeholder="" />
</div>
<div class="table_cell">
<button type="button" class="btn btn-primary" name="button_search">Найти</button>
</div>
</div>
</div>

<div class="table table_list">
<div class="table_row bolder center inverter">
<div class="table_cell border">
ФИО
</div>
<div class="table_cell border">
Фото
</div>
<div class="table_cell border">
Характеристики
</div>
<div class="table_cell border">
Колличество проектов
</div>
<div class="table_cell border">
Удалить
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
$characteristics .= 'коммуникабельность:'.$value['sociability'].'<br>'; 
$characteristics .= 'инженерные навыки:'.$value['engineering'].'<br>'; 
$characteristics .= 'тайм менеджмент:'.$value['timemanagement'].'<br>'; 
$characteristics .= 'знание языков:'.$value['languages'].'<br>'; 
echo $characteristics;
?>
</div>
<div class="table_cell border center">
<?php 
echo $value['result']; 
?>
</div>
<div class="table_cell border center">
<button type="button" id="<?php echo $value['id']; ?>" class="button_remove btn btn-primary" name="/<?php echo $value['photo']; ?>">удалить</button>
</div>
</div>
<?php
}
?>
</div>

<hr>

<div>
<?php 
echo 'Среднее "коммуникабельность":<b>'.$average[0]['average_sociability'].'</b><br>';
echo 'Среднее "инженерные навыки":<b>'.$average[0]['average_engineering'].'</b><br>';
echo 'Среднее "тайм менеджмент":<b>'.$average[0]['average_timemanagement'].'</b><br>';
echo 'Среднее "знание языков":<b>'.$average[0]['average_languages'].'</b><br>';
?>
</div>

</div>

