<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Worker;
use app\models\Upload;
use app\models\Project;
use app\models\Workerproject;

class WorkerController extends Controller
{
 
    public $layout = 'workerbase';

    public function actionRedirect($url = '')
    {

        if (substr($url, -1) === '/') {
            return $this->redirect('/' . substr($url, 0, -1), 301);
        }
        //else {
        //    throw new NotFoundHttpException;
        //}

        /*
        $pathInfo = Yii::$app->request->pathInfo;
        print_r($pathInfo); die;
        if (!empty($pathInfo) && substr($pathInfo, -1) !== '/') {
           Yii::$app->response->redirect('/' . rtrim($pathInfo) . '/', 301)->send();
        }
        */
    }

    public function actionIndex()
    {

        return $this->render('listworkers'); 

    }


    public function actionNewworker()
    {

       $model = new Worker();

       $model_project = new Project();

       $model_workerproject = new Workerproject();

        if($model->load(\Yii::$app->request->post()) && $model->validate()) {
          
          $model->name = Yii::$app->request->post('Worker')['name'];
          $session = Yii::$app->session;
          $model->photo = $session->get('photo');
          $model->sociability = Yii::$app->request->post('Worker')['sociability']; 
          $model->engineering = Yii::$app->request->post('Worker')['engineering'];       
          $model->timemanagement = Yii::$app->request->post('Worker')['timemanagement'];       
          $model->languages = Yii::$app->request->post('Worker')['languages'];                
          $model->insert();

          $id_add_item = $model->find()->max('id');
          if(Yii::$app->request->post('Worker')['id_projects']) {
            if(strpos(Yii::$app->request->post('Worker')['id_projects'], '#') === false) {
               $model_workerproject->id_worker = $id_add_item; 
               $model_workerproject->id_project = Yii::$app->request->post('Worker')['id_projects']; 
               $model_workerproject->insert();
            }
            else {
               $string_projects = substr(Yii::$app->request->post('Worker')['id_projects'], 1);
               $array_projects = explode('#', $string_projects);
               foreach($array_projects as $array_projects_value) {
                  $model_workerproject = new Workerproject();
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

       $model = new Worker();	

       $list = $model->find()
          ->select(['{{worker}}.[[id]]', '{{worker}}.[[name]]', '[[photo]]', '[[sociability]]', '[[engineering]]', '[[timemanagement]]', '[[languages]]', '{{project}}.[[name]] as name_project', 'count({{workerproject}}.[[id_worker]]) as result'])
          ->leftJoin('{{workerproject}}', '{{workerproject}}.[[id_worker]] = {{worker}}.[[id]]')
          ->leftJoin('{{project}}', '{{project}}.[[id]] = {{workerproject}}.[[id_project]]')
          ->where(['like', '{{worker}}.[[name]]', $search])
          ->groupBy('{{worker}}.[[id]]')
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
       $model = new Worker();

       $model_workerproject = new Workerproject();

       $model->findOne($id)->delete();

       $model_workerproject->deleteAll('id_worker = :id_worker', [':id_worker' => $id]); 

       if($photo != '/img/nophoto.jpg') {unlink(Yii::$app->basePath . '/web/' . $photo);}

       return $this->redirect('/worker');
    }    
   
}
