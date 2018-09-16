<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Categoryauto;

class CategoryautoController extends Controller
{

    public function actionIndex()
    {


       $model=new Categoryauto;

       //$sql='select `categoryauto`.`id`, `categoryauto`.`parent_category_id`, `categoryauto`.`name` from `categoryauto`';
       ////where `categoryauto`.`id` in (select `categoryauto`.`parent_category_id` from `categoryauto`)';
       /*
       $sql='select t1.`id` as t1_id, t1.`parent_category_id` as t1_parent_category_id,
       t2.`id` as t2_id, t2.`parent_category_id` as t2_parent_category_id,
       t1.`name` as parent_name, t2.`name` as child_name
       from `categoryauto` as t1, `categoryauto` as t2 where t1.`id`=t2.`parent_category_id`';
       //from `categoryauto` as t1 where t1.`id` in (select t2.`parent_category_id` from `categoryauto`) as t2';
       */
       //$sql='select `categoryauto`.`id`, `categoryauto`.`parent_category_id`, `categoryauto`.`name` from `categoryauto`';

       //$sql='select `categoryauto`.`id`, `categoryauto`.`parent_category_id`, `categoryauto`.`name`
       //from `categoryauto`
       //where `categoryauto`.`id`<>all(select `categoryauto`.`parent_category_id` from `categoryauto`)';

       $sql='select `categoryauto`.`id`, `categoryauto`.`parent_category_id`, `categoryauto`.`name`, `categoryauto`.`chain`
       from `categoryauto`
       where `categoryauto`.`id`<>all(select `categoryauto`.`parent_category_id` from `categoryauto`) order by `categoryauto`.`chain`';

       //$sql='select `categoryauto`.`chain` from `categoryauto`
       //where `categoryauto`.`id`<>all(select `categoryauto`.`parent_category_id` from `categoryauto`)  order by `categoryauto`.`chain`';

       $results=$model->db->createCommand($sql)->queryAll();

       return $this->renderPartial('index', ['results'=>$results]);

    }

}
