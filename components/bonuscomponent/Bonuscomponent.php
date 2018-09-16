<?php
namespace app\components\bonuscomponent;

use Yii;
use app\models\Bonusrequest;

class Bonuscomponent


{

    public static function stepFirst($idevent)
    {

       
       $session = Yii::$app->session;
       if($session->get('iduser')) {
          $iduser = $session->get('iduser');
            
          //db...  
          $model = new Bonusrequest;
          $model->iduser = $session->get('iduser');
          $model->idevent = $idevent;
          $model->insert();
          //db...

          //delete after...
          return $iduser.' - '.$idevent;  
          //delete after...
       }

    }

}
