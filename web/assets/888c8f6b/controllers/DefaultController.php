<?php

namespace app\modules\forum\controllers;

use yii\web\Controller;
use app\modules\forum\models\Basemod;

class DefaultController extends Controller
{

   public $layout = 'base';

   public function actionIndex(){

     $model=new Basemod;

     //print_r('Hello module...'); echo '<br>';
     //return $this->renderPartial('index');
     return $this->render('index', ['model' => $model]);
     //return $this->render('index', ['model' => $model]);
   }

   public function actionAjaxbaseapi() {

     $model=new Basemod;

     $money=$_GET['what'];
     echo $model->baseapi($money);

   }

}
