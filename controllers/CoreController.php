<?php

namespace app\controllers;

use Yii;  
use yii\web\Controller;
use app\models\Core;
use app\components\bonuscomponent\Bonuscomponent;

class CoreController extends Controller
{

    public $layout = 'baselayout';
    
    public function actionIndex()
    {


        $session = Yii::$app->session;
        $iduser = mt_rand(1, 10000);
        $session->set('iduser', $iduser);

        return $this->render('index');
        
    }

    public function actionFromcore($event = null)
    {

       //print_r('actionFromcore'); 
       return Bonuscomponent::stepFirst($event);

    }


}
