<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Workers;
use app\models\Uploads;
use app\models\Projects;
use app\models\Workersproject;

class WorkersController extends Controller
{
 
    public $layout = 'workersbase';

    public function actionIndex()
    {

        return $this->render('listworkers'); 

    }


    public function actionNewworker()
    {

       $model = new Workers();

       $model_project = new Projects();

       $model_workerproject = new Workersproject();

        if($model->load(\Yii::$app->request->post()) && $model->validate()) {
          
          $model->name = Yii::$app->request->post('Workers')['name'];
          $session = Yii::$app->session;
          $model->photo = $session->get('photo');
          $model->sociability = Yii::$app->request->post('Workers')['sociability'];
          $model->engineering = Yii::$app->request->post('Workers')['engineering'];
          $model->timemanagement = Yii::$app->request->post('Workers')['timemanagement'];
          $model->languages = Yii::$app->request->post('Workers')['languages'];
          $model->insert();

          $id_add_item = $model->find()->max('id');
          if(Yii::$app->request->post('Workers')['id_projects']) {
            if(strpos(Yii::$app->request->post('Workers')['id_projects'], '#') === false) {
               $model_workerproject->id_worker = $id_add_item; 
               $model_workerproject->id_project = Yii::$app->request->post('Workers')['id_projects'];
               $model_workerproject->insert();
            }
            else {
               $string_projects = substr(Yii::$app->request->post('Workers')['id_projects'], 1);
               $array_projects = explode('#', $string_projects);
               foreach($array_projects as $array_projects_value) {
                  $model_workerproject = new Workersproject();
                  $model_workerproject->id_worker = $id_add_item; 
                  $model_workerproject->id_project = $array_projects_value; 
                  $model_workerproject->insert();   
               }
            }
          }

          return $this->render('newworker', ['model' => $model]); 
       } 
       else {
          return $this->render('newworker', ['model' => $model]);  
       }     

    }

    public function actionListworkers($search = '')
    {

       $model = new Workers();

       $list = $model->find()
          ->select(['{{workers}}.[[id]]', '{{workers}}.[[name]]', '[[photo]]', '[[sociability]]', '[[engineering]]', '[[timemanagement]]', '[[languages]]', '{{projects}}.[[name]] as name_project', 'count({{workersproject}}.[[id_worker]]) as result'])
          ->leftJoin('{{workersproject}}', '{{workersproject}}.[[id_worker]] = {{workers}}.[[id]]')
          ->leftJoin('{{projects}}', '{{projects}}.[[id]] = {{workersproject}}.[[id_project]]')
          ->where(['like', '{{workers}}.[[name]]', $search])
          ->groupBy('{{workers}}.[[id]]')
          ->asArray()
          ->all();

      $average = $model->find()
          ->select(['round(sum([[sociability]])/count(*),2) as average_sociability', 'round(sum([[engineering]])/count(*),2) as average_engineering', 'round(sum([[timemanagement]])/count(*),2) as average_timemanagement', 'round(sum([[languages]])/count(*),2) as average_languages'])
          ->asArray()
          ->all();  

       if($search == '') {
          return $this->render('listworkers', ['model' => $model, 'list' => $list, 'average' => $average]);  
       } 
       else {
          return json_encode($list); 
       }

    }

    public function actionRemoveworker($id, $photo)
    {
       $model = new Workers();

       $model_workerproject = new Workersproject();

       $model->findOne($id)->delete();

       $model_workerproject->deleteAll('id_worker = :id_worker', [':id_worker' => $id]);

       if($photo != '/img/nophoto.jpg') {unlink(Yii::$app->basePath . '/web/' . $photo);}

       return $this->redirect('/workers');
    }    
   
}
