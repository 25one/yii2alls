<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Tree;

class TreeController extends Controller
{

    public function actionIndex()
    {

       $model=new Tree;

       return $this->renderPartial('index', ['model' => $model]);

    }

    public function actionAutoloadhook()
	{

      $model=new Tree;

      //$model->trigger(Tree::EVENT_TITLE_ADD);

      $model->showDom();

    }

    public function actionAddupdateremovehook()
	{

      $model=new Tree;

      $parent_string=$_GET['who'];
      $act=$_GET['what'];
      $value=$_GET['val'];
      if($act=='add' and $value=='') {$value='New level...';}
      $model->actDb($parent_string, $act, $value);

    }

}
