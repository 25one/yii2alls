<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Getparametrs;

class GetparametrsController extends Controller
{

    public function actionIndex($id)
    {

       $model=new Getparametrs;

       return $this->renderPartial('index', [
           'id' => $id,
       ]);

    }

}
