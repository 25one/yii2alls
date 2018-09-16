<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Surprisenew;

class CmdsurpriseController extends Controller
{

    public $message;

    public function options($actionID)
    {
        return ['message'];

    }

    public function actionIndex($message = 'hello world')
    // php yii hello -message=hello
    //public function actionIndex()
    {

        echo $this->message . "\n";


    }

    // php yii cmdsurprise/status 1
    public function actionStatus($code_status)
    {
       //echo $code_status . "\n";
       $model = new Surprisenew;
       //$row_db_result = $model->find()->where(['[[status]]' => $code_status])->orderBy('[[name]]')->asArray()->all();  //...ActiveRecord...
       $row_db_result = (new \yii\db\Query()) //...Builder...
       ->select(['[[name]]', '[[limit_for_all]]', '[[limit_for_one]]'])
       ->from('{{surprisenew}}')
       ->where('[[status]] = :status')
       ->addParams([':status' => $code_status])
       ->orderBy('[[name]]')
       ->all();
       //print_r($row_db_result)."\n";
       foreach($row_db_result as $result) {
          print_r($result['name'].' - '.$result['limit_for_all'].' - '.$result['limit_for_one']."\n");
       }

    }

    /*
    // php yii hello/create test גûחמגוע "actionCreate('test')
    public function actionCreate($name)
    {
       echo $name . "\n";
    }

    // php yii hello/category city גûחמגוע actionCategory('city', 'name')
    // php yii hello/category city id גûחמגוע actionCategory('city', 'id')
    public function actionCategory($category, $order = 'name')
    {
       echo $category.' - '.$order. "\n";
    }

    // php yii hello/add test גûחמגוע actionAdd(['test']) !!![...]
    // php yii hello/add test1,test2 גûחמגוע actionAdd(['test1', 'test2']) !!!...,... + [...]
    public function actionAdd(array $name)  //!!!array
    {
       print_r($name). "\n";
    }
    */

}

