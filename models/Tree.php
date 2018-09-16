<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tree extends ActiveRecord
{

const EVENT_TITLE_ADD='title_add';

public function titleAdd($event){
   echo '<b>event:</b> titleAdd<br>';
   // you code
   //die;
}

public function init(){
  $this->on(self::EVENT_TITLE_ADD, [$this, 'titleAdd']);
}

public function showDom() {
fopen('filetemplate/categoryauto_template_array.php', 'r');
$array_template=file_get_contents('filetemplate/categoryauto_template_array.php');
$r1="/:{}/";
$r2="/:{/";
$r3="/{/";
$r4="/,/";
$r5="/}/";
$r6='/(\d+)((_(\d+))*)/';
$r7='/"/';
$dom_string=preg_replace($r1, '', $array_template);
$dom_string=preg_replace($r2, '<ul><li>', $dom_string);
$dom_string=preg_replace($r3, '<ul><li>', $dom_string);
$dom_string=preg_replace($r4, '</li><li>', $dom_string);
$dom_string=preg_replace($r5, '</li></ul>', $dom_string);
$dom_string=preg_replace($r6, '<img src="filetemplate/update.jpg" name="$1$2#" alt />&nbsp;<?php if($out_[\'$4\']) echo \'<span name="level_title_$1$2#">\'.$out_[\'$4\'].\'&nbsp;</span>\'; else echo \'<span name="level_title_$1$2#">\'.$out_[\'$1\'].\'&nbsp;</span>\'; ?><img src="filetemplate/add.png" name="$1$2#" alt />&nbsp;<?php if($out_[\'$4\']) echo \'<img src="filetemplate/delete.png" name="$1$2#" alt />\'; ?>', $dom_string);
$dom_string=preg_replace($r7, '', $dom_string);
fopen('filetemplate/categoryauto_template_dom.php', 'w');
file_put_contents('filetemplate/categoryauto_template_dom.php', $dom_string);
$row_db=$this->find()->asArray()->all();
foreach($row_db as $out) {$out_[$out['id']]=$out['name'];}
require_once('filetemplate/categoryauto_template_dom.php');
}

public function actDb($parent_string, $act, $value) {
$connection=\Yii::$app->db;
$r1="/(_)*\d+#/u";
$r2="/\d+/u";
preg_match($r1, $parent_string, $parent1);
preg_match($r2, $parent1[0], $parent2);
if($act=='add') {
$this->parent_category_id=$parent2[0];
$this->name=$value;
$this->save();
$id=$this->find()->max('id');
$act_parametr='add';
$this->replaceTemplateArray($parent_string, $id, $act_parametr);
}
else if($act=='update') {
$connection->createCommand()
        ->update('tree', ['name'=>$value], ['id'=>$parent2[0]])
        ->execute();
}
else if($act=='remove') {
$this->findOne($parent2[0])->delete();
$connection->createCommand('delete from tree where parent_category_id<>all(select t.id from (select id from tree) as t) and parent_category_id<>0')
        ->execute();
$id='';
$act_parametr='remove';
$this->replaceTemplateArray($parent_string, $id, $act_parametr);
}
}

public function replaceTemplateArray($parent_string, $id, $act_parametr) {
$parent_string=str_replace('#', '', $parent_string);
$arr_level=explode('_', $parent_string);
if(count($arr_level)>1) {
   $levels='$arr_replace->{"'.$arr_level[0].'"}';
   $l=$arr_level[0];
   for($i=1; $i<count($arr_level)-1; ++$i) {
      $levels.='->{"'.$l.'_'.$arr_level[$i].'"}';
      $l=$l.'_'.$arr_level[$i];
   }
   $levels.='->{"'.$parent_string.'"}';
}
else {
   $levels='$arr_replace->{"'.$parent_string.'"}';
}
if($act_parametr=='add') {
$act_level=$levels.'->{"'.$parent_string.'_'.$id.'"}=(object)array();';
}
else if($act_parametr=='remove') {
$act_level='unset('.$levels.');';
}
fopen('filetemplate/categoryauto_template_replace_array.php', 'w');
file_put_contents('filetemplate/categoryauto_template_replace_array.php', "<?php \$arr_replace=json_decode(file_get_contents('filetemplate/categoryauto_template_array.php')); ".$act_level);
require_once('filetemplate/categoryauto_template_replace_array.php');
fopen('filetemplate/categoryauto_template_array.php', 'w');
file_put_contents('filetemplate/categoryauto_template_array.php', json_encode($arr_replace));
}

}
