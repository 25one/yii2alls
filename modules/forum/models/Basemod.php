<?php

namespace app\modules\forum\models;  //...!!!ÄÎËÆÍÎ ÁÛÒÜ...

//use yii\db\ActiveRecord;

//class Basemod extends Models //!!!...ÅÑËÈ ÁÅÇ ÏÐÈÂßÇÊÈ Ê ÊÎÊÐÅÒÍÎÉ ÒÀÁËÈÖÅ...
class Basemod       //...ÐÀÑØÈÐÅÍÈÅ ÌÎÄÅËÈ - ÁÅÇ extends Models...
{

    public $baseapi;  //...ÐÀÑØÈÐÅÍÈÅ ÌÎÄÅËÈ...

    public function baseapi($money)
    {
       $result=json_decode(file_get_contents('http://api.25one.com.ua/api_casexe.php?money='.$money));
       return $result->title;
    }

}
