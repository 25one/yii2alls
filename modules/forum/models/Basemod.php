<?php

namespace app\modules\forum\models;  //...!!!������ ����...

//use yii\db\ActiveRecord;

//class Basemod extends Models //!!!...���� ��� �������� � ��������� �������...
class Basemod       //...���������� ������ - ��� extends Models...
{

    public $baseapi;  //...���������� ������...

    public function baseapi($money)
    {
       $result=json_decode(file_get_contents('http://api.25one.com.ua/api_casexe.php?money='.$money));
       return $result->title;
    }

}
