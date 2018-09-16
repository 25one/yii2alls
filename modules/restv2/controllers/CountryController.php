<?php

namespace app\modules\restv2\controllers;

//use yii\rest\ActiveController; //?...
use yii\rest\Controller;       //!...
//use app\models\Country;        //!!!!!...
use app\modules\restv2\models\Country;        //!!!!!...
use app\models\Mylogin;        //!...

//class CountryController extends ActiveController //?...
class CountryController extends Controller //!...
{
    //public $modelClass = 'app\models\Country'; //?!...

    /*
    public function actions()
    {

        //$actions = parent::actions();    //...???!!!СТАНДАРТНЫЕ - У МЕНЯ ПОКА СВОИ...

        // отключить действия "delete" и "create"
        //unset($actions['delete'], $actions['create']);

        return $actions;
    }
    */

    /*
    public function checkAccess($action, $model = null, $params = [])
    {
        // проверить, имеет ли пользователь доступ к $action и $model
        // выбросить ForbiddenHttpException, если доступ следует запретить
        if ($action === 'update' || $action === 'delete') {
            if ($model->author_id !== \Yii::$app->user->id)
                throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
        }
    }
    */

    public function checkAccess($user)
    {
        if(Mylogin::findOne($user)) {
            return Mylogin::find()->where(['id' => $user])->asArray()->all()[0]['username'];
        }
     }

    public function actionIndex()
    {
        // curl -i -H "Accept:application/json" "http://yii2.25one.com.ua/country/viewitem?code=US"
        return Country::find()->all();
    }

    public function actionViewitem($code=null)
    {
        // curl -i -H "Accept:application/json" "http://yii2.25one.com.ua/country/viewitem?code=US"
      if($code) {
        return Country::findOne($code);
      }
      else {
        return "Error format of url-string...";
      }
    }

    public function actionDeleteitem($code=null, $user=null)
    {
        // curl -i -H "Accept:application/json" "http://yii2.25one.com.ua/country/deleteitem?code=US"
      if($code && $user) {
        if($this->checkAccess($user)) {
            if(Country::findOne($code)->delete()) {
               return "Success of deleting...";
            }
            else {
               return "Error of deleting...";
            }
        }
        else {
            //throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created...'));
            return "You can't delete this item...";
        }
      }
      else {
            return "Error format of url-string...";
      }
    }

}
