<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Cartree;

class CartreeController extends Controller
{
 
    public $layout = 'cartreebase';

    public function actionIndex()
    {
       $model = new Cartree();

       $subQuery = $model->find()->select(['min([[parent_id]])']);
       $list = $model->find()
          ->select(['[[id]]', '[[name]]'])
          ->where(['in', '[[parent_id]]', $subQuery])
          ->asArray()
          ->all();

       return $this->render('index', ['model' => $model, 'list' => $list]);
        
    }

    public function actionAjaxSelect($all)
    {
       $allArray = explode('#', $all);

       $model = new Cartree();

       $subQuery = $model->find()->select(['[[parent_id]]'])
           ->andWhere(['[[parent_id]]' => $allArray]);
       $list = $model->find()
           ->select(['[[name]]'])
           ->where(['in', '[[parent_id]]', $subQuery])
           ->andWhere(['!=', '[[parent_id]]', '0'])
           ->asArray()
           ->all();
       return json_encode($list);    
    }

}
